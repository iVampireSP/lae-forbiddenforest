<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $post = new Post();

        if ($request->filled('search')) {
            $post = $post->search($request->input('search'));
        }

        // 根据 published_at 排序
        $post = $post->orderBy('published_at', 'desc');

        $post = $post->with('blog.user');

        return $this->success($post->paginate());
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): JsonResponse
    {
        return $this->success($post);
    }
}
