<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return $this->success(Post::paginate());
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): JsonResponse
    {
        return $this->success($post);
    }
}
