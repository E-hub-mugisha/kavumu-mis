<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $roles)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized: Not logged in');
        }

        // Split roles by pipe or comma and make case-insensitive
        $allowedRoles = array_map('strtolower', preg_split('/[|,]/', $roles));

        if (!in_array(strtolower($user->role), $allowedRoles)) {
            abort(403, 'Unauthorized: Your role is not allowed');
        }

        return $next($request);
    }
}
