<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            // 博客 ID
            $table->foreignId('blog_id')->constrained()->onDelete('cascade');

            // 博客中存储的文章 ID
            $table->string('blog_post_id')->index();

            // 文章标题
            $table->string('title')->index();

            // 摘要
            $table->string('excerpt')->nullable();

            // URL
            $table->string('url')->nullable();

            // 发布时间
            $table->timestamp('published_at')->nullable();

            // 上次同步时间
            $table->timestamp('synced_at')->nullable();

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
