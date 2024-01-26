<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        $userRoles = explode(',', auth()->user()->user_role);

        foreach ($roles as $role) {
            if (in_array($role, $userRoles)) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized action.');
    }
}
