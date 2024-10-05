<?php

namespace App\Http\Middleware;

use Closure;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if the authenticated user is a superadmin
        if (backpack_user()->isSuperAdmin()) {
            return $next($request);
        }

        // Redirect non-superadmins to a different page or show an error
        return redirect('/admin')->with('error', 'Unauthorized access.');
    }
}
