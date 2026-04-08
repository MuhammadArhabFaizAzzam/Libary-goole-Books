<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and has the 'admin' role.
        // The nullsafe operator (?->) is used for safety in case there is no user.
        if ($request->user()?->role === 'admin') {
            // Redirect admins to the admin dashboard.
            return redirect()->route('admin.dashboard');
        }

        // For non-admins, continue with the original request.
        return $next($request);
    }
}
