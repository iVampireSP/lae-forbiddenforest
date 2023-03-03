<?php

namespace App\Jobs;

use App\Models\Blog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RefreshPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Blog $blog;

    protected int $page = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Blog $blog, int $page = 1)
    {
        $this->blog = $blog;
        $this->page = $page;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // 获取 Tag
        $tag = $this->blog->getTag(config('blog.posts.slug'));

        if (! $tag) {
            return;
        }

        // 刷新所有文章
        $posts = $this->blog->getPosts([
            'page' => $this->page,
            'limit' => 100,
            'tags' => [
                $tag[0]['id'],
            ],
        ]);

        if (! $posts) {
            return;
        }

        if (isset($posts['code']) && $posts['code'] === 'rest_post_invalid_page_number') {
            return;
        }

        // posts 转 collection
        $posts = collect($posts);

        if ($posts->count() > 0) {
            $posts->each(function ($post) {
                // 摘要，去除 html 标签
                $post['excerpt']['rendered'] = strip_tags($post['excerpt']['rendered'] ?? '');

                $this->blog->posts()->updateOrCreate([
                    'blog_post_id' => $post['id'],
                ], [
                    'title' => $post['title']['rendered'],
                    'excerpt' => $post['excerpt']['rendered'],
                    'published_at' => $post['date'],
                    'blog_post_id' => $post['id'],
                    'synced_at' => now(),
                    'url' => $post['link'],
                ]);
            });

            $this->page++;
            self::dispatch($this->blog, $this->page);
        }
    }
}
