<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response|RedirectResponse) $next
     */
    public function handle(Request $request, Closure $next): Response|JsonResponse|RedirectResponse
    {
        // if bearer token is not set
        if (! $request->bearerToken() || $request->bearerToken() !== config('app.api_token')) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        return $next($request);
    }
}
