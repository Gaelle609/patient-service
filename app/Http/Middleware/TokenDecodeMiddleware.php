<?php

namespace App\Http\Middleware;

use App\Auth\JwtUser;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TokenDecodeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    $authHeader = $request->header('Authorization');

    if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
        return response()->json(['error' => 'Token manquant ou invalide'], 401);
    }

    $token = substr($authHeader, 7);

    try {
        $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

        // Créer un JwtUser et l'injecter dans Auth
        $jwtUser = new JwtUser((array) $decoded);
        Auth::setUser($jwtUser);

    } catch (\Exception $e) {
        return response()->json(['error' => 'Token invalide'], 401);
    }

    return $next($request);
}

}
