<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthenticationMiddleware
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = $this->authService->validateToken($token);

        if (!$user) {
            return response()->json(['message' => 'Invalid Token'], 401);
        }

        return $next($request);
    }
}
