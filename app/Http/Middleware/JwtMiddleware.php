<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\JwtHelper;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('accessToken');

        if (!$token) {
            return response()->json(['error' => 'Token cookie not found'], 401);
        }

        $decodedToken = JwtHelper::validateToken($token);

        if (!$decodedToken) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        return $next($request);
    }
}
