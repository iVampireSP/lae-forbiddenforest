<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    public $fillable = [
        'title',
        'excerpt',
        'blog_id',
        'blog_post_id',
        'published_at',
        'synced_at',
        'url',
    ];

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }
}
