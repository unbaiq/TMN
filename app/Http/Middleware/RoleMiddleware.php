<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // If user is NOT logged in → send to admin login page
        if (! Auth::check()) {
            return redirect()->route('admin.login');
        }

        $user = Auth::user();

        // Check if user role is NOT allowed
        if (! in_array($user->role, $roles)) {

            // If admin tries to open member area → redirect to admin dashboard
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // If member tries to open admin area → redirect to member dashboard
            if ($user->role === 'member') {
                return redirect()->route('member.dashboard');
            }

            // fallback
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
