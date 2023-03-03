<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return $this->success(Blog::where('status', 'up')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $user = $request->user('api');
        // 如果用户已经有博客了，就不允许再创建
        if ($user->blog) {
            return $this->conflict('您已经有博客了。');
        }

        $request->validate([
            'url' => 'required|url',
            'username' => 'required',
            'password' => 'required',
        ]);

        // 检查博客
        $http = Http::wp($request->input('url'), $request->input('username'), $request->input('password'));
        $response = $http->get('/wp-json/wp/v2/posts');

        if ($response->failed()) {
            return $this->badRequest('博客验证失败。');
        }

        $blog = $request->user()->blog()->create($request->only([
            'url',
            'username',
            'password',
        ]));

        return $this->created($blog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog): JsonResponse
    {
        $request->validate([
            'url' => 'nullable|url',
        ]);

        $url = $request->input('url') ?? $blog->url;
        $username = $request->input('username') ?? $blog->username;
        $password = $request->input('password') ?? $blog->password;

        $http = Http::wp($url, $username, $password);
        $response = $http->get('/wp-json/wp/v2/posts');

        if ($response->failed()) {
            return $this->badRequest('博客验证失败。');
        }

        $blog->update($request->only([
            'url', 'username', 'password',
        ]));

        return $this->updated($blog);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog): JsonResponse
    {
        $blog->delete();

        return $this->deleted();
    }
}
