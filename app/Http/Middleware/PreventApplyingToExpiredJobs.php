<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventApplyingToExpiredJobs
{
    /**
     * Alias: job.not_expired
     * Block a seeker from applying to a job whose deadline has passed.
     * Apply to the apply GET and POST routes after job.seeker.
     *
     * GET  /jobs/{jobPost}/apply  → redirect back to the job page with an error
     * POST /jobs/{jobPost}/apply  → abort 422 so the form never silently saves
     */
    public function handle(Request $request, Closure $next): Response
    {
        $jobPost = $request->route('jobPost');

        if ($jobPost && Carbon::parse($jobPost->deadline)->isPast()) {
            if ($request->isMethod('GET')) {
                return redirect()
                    ->route('jobs.show', $jobPost->id)
                    ->with('error', 'The application deadline for this job has passed.');
            }

            abort(422, 'The application deadline for this job has passed.');
        }

        return $next($request);
    }
}