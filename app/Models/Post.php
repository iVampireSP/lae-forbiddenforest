<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use SoftDeletes, Searchable;

    public $fillable = [
        'title',
        'excerpt',
        'blog_id',
        'blog_post_id',
        'published_at',
        'synced_at',
        'url',
    ];

    public $with = [
        'blog.user',
    ];

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }

    /**
     * 在使所有模型都可搜索时，修改用于检索模型的查询。
     */
    protected function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query->with('blog.user');
    }
}
