<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Drop-in replacement for Laravel's built-in guest middleware.
     * Laravel's default redirects to '/home' which does not exist in this app.
     * This version sends already-authenticated users to jobs.index instead.
     *
     * NO registration needed — drop the file in app/Http/Middleware/ and
     * Laravel replaces the framework version automatically because the
     * namespace + class name are identical.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect()->route('jobs.index');
            }
        }

        return $next($request);
    }
}