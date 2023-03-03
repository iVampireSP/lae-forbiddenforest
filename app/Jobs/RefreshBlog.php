<?php

namespace App\Jobs;

use App\Models\Blog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RefreshBlog implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ?Blog $blog = null;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($blog = null)
    {
        $this->blog = $blog;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // 删除上次同步时间超过 1 天的文章
        if (! $this->blog) {
            Blog::chunk(100, function ($blog) {
                $blog->each(function (Blog $blog) {
                    self::dispatch($blog);
                    $blog->posts()->where('synced_at', '<', now()->subDay())->delete();
                });
            });

            return;
        }

        if ($this->blog->testConnection() === false) {
            $this->blog->update([
                'status' => 'down',
            ]);

            return;
        } else {
            if ($this->blog->status === 'down') {
                $this->blog->update([
                    'status' => 'up',
                ]);
            }
        }

        $this->blog->getSettings();

        dispatch(new RefreshPost($this->blog));
    }
}
