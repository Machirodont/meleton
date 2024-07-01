<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SimpleTokenAuth
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->bearerToken() !== config('auth.auth_token')) {
            return new JsonResponse([
                'status' => 'error',
                'code' => 403,
                'message' => 'Invalid token',
            ], 403);
        }

        return $next($request);
    }
}
