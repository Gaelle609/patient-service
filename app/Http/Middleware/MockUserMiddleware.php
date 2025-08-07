<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MockUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       if (config('app.mock_auth')) {
            $request->merge([
                'user' => [
                    'id' => config('app.mock_user_id'),
                    'name' => 'Mock User',
                    'email' => 'mock@example.com'
                ]
            ]);
        }
        
        return $next($request);
    }
}
