<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureJobOwner
{
    /**
     * Alias: job.owner
     * Confirm the authenticated job poster owns the {jobPost} route model.
     * Must run AFTER job.poster so $user->jobPoster is guaranteed to exist.
     *
     * Use on any route that binds {jobPost} and needs ownership:
     *   edit, update, destroy, jobApplications
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User $user */
        $user    = $request->user();
        $jobPost = $request->route('jobPost');

        if (!$jobPost || (int) $jobPost->job_poster_id !== (int) $user->jobPoster->id) {
            abort(403, 'You do not own this job post.');
        }

        return $next($request);
    }
}