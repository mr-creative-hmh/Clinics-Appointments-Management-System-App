<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Debugging: Log role names and user roles
        Log::info('Roles to check:', $roles);
        Log::info('User roles:', auth()->user()->roles->pluck('name')->toArray());
        // Check if the user has any of the required roles
        // foreach ($roles as $role) {
        //     if (auth()->user()->hasRole($role)) {
        //         return $next($request);
        //     }
        // }

        // If the user doesn't have the required role, return a 403 Forbidden response
        return response()->json(['message' => 'Forbidden'], 403);
    }
}
