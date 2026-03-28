<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureJobPoster
{
    /**
     * Alias: job.poster
     * Allow only users whose user_type is 'job_poster'.
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        if (!$user || $user->user_type !== 'job_poster') {
            abort(403, 'Only employers can access this page.');
        }

        return $next($request);
    }
}