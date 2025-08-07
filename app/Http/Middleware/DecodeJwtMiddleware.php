<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\HttpFoundation\Response;

class DecodeJwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token = $request->bearerToken();
            
            if (!$token) {
                return response()->json(['error' => 'Token not provided'], 401);
            }
            
            $decoded = JWT::decode($token, new Key(config('jwt.secret'), config('jwt.algo')));
            $request->merge(['user' => (array)$decoded->user]);
            
            return $next($request);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        }
    }
}
