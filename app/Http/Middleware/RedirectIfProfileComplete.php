<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfProfileComplete
{
    /**
     * Alias: profile.incomplete
     * Inverse of EnsureProfileComplete.
     * Prevents a user who already has a profile from hitting /setup-profile again,
     * which would create a duplicate JobSeeker or JobPoster record.
     *
     * Apply only to the setup-profile routes.
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user && ($user->jobSeeker || $user->jobPoster)) {
            if (!$user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }

            return redirect()->route('jobs.index');
        }

        return $next($request);
    }
}