<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleOrPermissionMiddleware
{
    /**
     * Handle an incoming request.
     * Check if user has either a role OR a permission.
     */
    public function handle($request, Closure $next, $roleOrPermission)
    {
        $user = Auth::user();
        if (!$user || (! $user->hasRole($roleOrPermission) && ! $user->hasPermission($roleOrPermission))) {
            abort(403, 'Unauthorized: You do not have the required role or permission.');
        }
        return $next($request);
    }
}
