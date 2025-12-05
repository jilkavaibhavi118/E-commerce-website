<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Check if user has a specific role.
     */
    public function handle($request, Closure $next, $role)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole($role)) {
            abort(403, 'Unauthorized: You do not have the required role.');
        }
        return $next($request);
    }
}
