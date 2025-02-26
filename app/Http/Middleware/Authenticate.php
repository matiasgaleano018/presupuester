<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;

class Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    public function handle(Request $request, Closure $next, $role = null)
    {
        // Verificar si el usuario tiene el rol requerido
        if (!$request->user() || $request->user()->role !== $role) {
            return response()->json(['error' => 'Acceso no autorizado'], 403);
        }

        return $next($request);
    }
}
