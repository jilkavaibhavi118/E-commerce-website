<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     * Check if user has a specific permission.
     */
    public function handle($request, Closure $next, $permission)
    {
        $user = Auth::user();
        if (!$user || !$user->hasPermission($permission)) {
            abort(403, 'Unauthorized: You do not have the required permission.');
        }
        return $next($request);
    }
}
