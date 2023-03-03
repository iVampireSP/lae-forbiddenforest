<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\BlogPostController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/**
 * Functions
 * 暴露给用户的函数，由网关进行调用
 * 但是请注意，请求内容不能过大，必须在 5s 内完成请求，否则会导致请求失败。
 * 认证 Guard: api。可以通过 $request->user('api') 获取用户信息。
 */
Route::get('user', UserController::class);
Route::apiResource('blogs', BlogController::class)->middleware('resource_owner:blog');
Route::apiResource('posts', PostController::class)->only(['index', 'show']);
Route::apiResource('blogs.posts', BlogPostController::class)->only(['index', 'store', 'update', 'destroy'])->only(['index', 'show']);
Route::get('blogs/{blog}/posts/{post}/comments', [BlogPostController::class, 'comments']);
Route::post('blogs/{blog}/posts/{post}/comments', [BlogPostController::class, 'storeComment']);
