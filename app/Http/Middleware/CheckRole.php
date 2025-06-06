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

        if (in_array($user->role->slug, $roles)) {
        return $next($request);
    }
        return redirect('home')->with('error', "Unauthorized access");
        // return redirect('home')->with('error', "You don't have access to this page");
    }
}
