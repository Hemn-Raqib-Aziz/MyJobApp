<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileComplete
{
    /**
     * Redirect to profile setup if the user has not yet created
     * their JobSeeker or JobPoster profile.
     *
     * Register alias 'profile.complete' in bootstrap/app.php (L11)
     * or Kernel.php $middlewareAliases (L10).
     *
     * Typical stack: ['auth', 'verified', 'profile.complete']
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user && !$user->jobSeeker && !$user->jobPoster) {
            return redirect()->route('profile.setup', ['role' => $user->user_type]);
        }

        return $next($request);
    }
}