<?php

namespace App\Http\Middleware;

use App\Traits\ConsumesExternalService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AttachUserRolePermissionsMiddleware
{
    use ConsumesExternalService;

    protected $baseUri;

    public function __construct()
    {
        $this->baseUri = env('AUTH_URL');
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Unauthorized: No token provided'], 401);
        }

        $headers = ['Authorization' => "Bearer $token"];
        
        // Appel de l'API pour récupérer les informations de l'utilisateur
        $response = $this->performRequest('GET', '/api/users/get', [], $headers);
        
        if (is_string($response)) {
            $response = json_decode($response, true);
        }

        if (!is_array($response) || !isset($response['user'])) {
            return response()->json(['error' => 'Unauthorized: Invalid token'], 401);
        }

        // Injection des rôles et permissions dans la requête
        $request->merge([
            'user' => $response['user'],
            'role' => $response['role'],
            'permissions' => $response['permissions'],
        ]);
        dd($request);

        return $next($request);
    }
}
