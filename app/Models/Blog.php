<?php

namespace App\Models;

use App\Jobs\RefreshBlog;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Throwable;

class Blog extends Model
{
    public $fillable = [
        'url',
        'name',
        'description',
        'username',
        'password',
        'status',
    ];

    public $hidden = [
        'username',
        'password',
    ];

    public ?PendingRequest $http = null;

    public array $settings = [];

    public static function booted()
    {
        static::creating(function (self $blog) {
            $blog->status = 'up';
        });

        static::created(function (self $blog) {
            dispatch(new RefreshBlog($blog));
        });

        static::updated(function (self $blog) {
            dispatch(new RefreshBlog($blog));
        });

        static::deleting(function (self $blog) {
            $blog->posts()->delete();
        });
    }

    public function http(): ?PendingRequest
    {
        // 检测 http 是否被初始化
        if ($this->http) {
            return $this->http;
        }

        $this->http = Http::wp($this->url, $this->username, $this->password);

        return $this->http;
    }

    public function scopeThisUser(): Builder|self
    {
        return $this->where('user_id', auth('api')->user()->id);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function validateAuth(): bool
    {
        $response = $this->http()->get('/wp-json/wp/v2/posts');

        return $response->successful();
    }

    public function testConnection(): bool
    {
        try {
            $response = $this->http()->throw()->get('/wp-json/wp/v2/posts');
        } catch (Throwable|Exception) {
            return false;
        }

        return $response->successful();
    }

    public function getSettings(): array
    {
        if ($this->settings) {
            return $this->settings;
        }

        $response = $this->http()->get('/wp-json/wp/v2/settings');

        $this->settings = $response->json();

        // 检测模型是否被创建
        if (! $this->exists) {
            return $this->settings;
        }

        if ($this->name !== $this->settings['title']) {
            $this->name = $this->settings['title'];
        }

        if ($this->description !== $this->settings['description']) {
            $this->description = $this->settings['description'];
        }

        if ($this->isDirty()) {
            $this->save();
        }

        return $this->settings;
    }

    public function getBlogName(): ?string
    {
        $settings = $this->getSettings();

        return $settings['title'] ?? null;
    }

    public function getBlogDescription(): ?string
    {
        $settings = $this->getSettings();

        return $settings['description'] ?? null;
    }

    public function getPosts(array $attributes = []): array
    {
        $attributes['slug'] = $attributes['slug'] ?? [config('blog.posts.slug')];

        $response = $this->http()->get('/wp-json/wp/v2/posts', $attributes);

        return $response->json();
    }

    public function getPost($blog_post_id): array
    {
        $response = $this->http()->get('/wp-json/wp/v2/posts/' . $blog_post_id);

        return $response->json();
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function getComments($blog_post_id)
    {
        $response = $this->http()->get('/wp-json/wp/v2/comments', [
            'post' => $blog_post_id,
        ]);

        return $response->json();
    }

    public function publishComment($blog_post_id, $content, $ua = 'LAE-ForbiddenForest/1.0')
    {
        $user = auth('api')->user();
        
        $response = $this->http()->post('/wp-json/wp/v2/comments', [
            'post' => $blog_post_id,
            'author_name' => $user->name,
            'author_email' => $user->email,
            'content' => $content,
            'author_user_agent' => $ua
        ]);

        return $response->json();
    }
}
