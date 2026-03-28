<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureJobSeeker
{
    /**
     * Alias: job.seeker
     * Allow only users whose user_type is 'job_seeker'.
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        if (!$user || $user->user_type !== 'job_seeker') {
            abort(403, 'Only job seekers can access this page.');
        }

        return $next($request);
    }
}