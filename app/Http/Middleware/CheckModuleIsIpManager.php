<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckModuleIsIpManager
{
    /**
     * Handle an incoming request.
     *
     * @param Request                                       $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     *
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        // 检测 X-Module 是否是 ip-manager
        if ($request->header('X-Module') !== 'ip-manager') {
            abort(403, 'X-Module header is not ip-manager.');
        }

        return $next($request);
    }
}
