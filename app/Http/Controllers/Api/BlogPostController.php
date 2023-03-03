<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Blog $blog): JsonResponse
    {
        return $this->success($blog->getPosts());
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog, $blog_post_id): JsonResponse
    {
        return $this->success($blog->getPost($blog_post_id));
    }

    public function comments(Blog $blog, $blog_post_id): JsonResponse
    {
        return $this->success($blog->getComments($blog_post_id));
    }

    public function storeComment(Request $request, Blog $blog, $blog_post_id): JsonResponse
    {
        $ua = $request->header('User-Agent');

        $response = $blog->publishComment($blog_post_id, $request->input('content'), $ua);
        unset($response['author_ip']);

        return $this->created($response);
    }
}
