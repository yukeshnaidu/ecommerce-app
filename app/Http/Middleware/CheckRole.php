<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)    
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Check if user has any of the required roles
        foreach ($roles as $role) {
            if ($user->roles->contains('slug', $role)) {
                return $next($request);
            }
        }

        // If no roles matched, check for super-admin as fallback
        if ($user->roles->contains('slug', 'super-admin')) {
            return $next($request);
        }

        return redirect('home')->with('error', "You don't have access to this page");
    }
}
