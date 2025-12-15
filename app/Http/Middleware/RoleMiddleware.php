<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $roles  Comma-separated list of roles
     */
    public function handle($request, Closure $next, $roles)
    {
        // Split by comma or pipe
        $allowedRoles = collect(preg_split('/[,\|]/', $roles))
            ->map(fn($r) => strtolower(trim($r)))
            ->toArray();
    
        $userRole = strtolower(trim(auth()->user()->role));
    
        \Log::info("Checking role: userRole=$userRole allowedRoles=" . implode(',', $allowedRoles));
    
        if (!in_array($userRole, $allowedRoles)) {
            abort(403, "Unauthorized. Your role: {$userRole}");
        }
    
        return $next($request);
    }
}