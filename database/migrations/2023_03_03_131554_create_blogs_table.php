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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            // 博客地址
            $table->string('url')->unique();

            // 博客名称
            $table->string('name')->nullable()->index();

            // 博客描述
            $table->string('description')->nullable();

            // 账号以及密码
            $table->string('username')->nullable();
            $table->string('password')->nullable();

            // tag
            $table->string('tag')->nullable();

            // 状态
            $table->enum('status', ['up', 'down'])->default('up');

            // user id
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
