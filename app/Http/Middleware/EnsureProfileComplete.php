<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileComplete
{
    /**
     * Alias: profile.complete
     * Redirect to /setup-profile if the user has no JobSeeker or JobPoster record yet.
     * Stack order: auth -> verified -> profile.complete -> job.seeker / job.poster
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