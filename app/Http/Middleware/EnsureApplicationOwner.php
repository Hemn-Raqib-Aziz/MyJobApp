<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApplicationOwner
{
    /**
     * Alias: app.owner
     * Confirm the authenticated job poster owns the {application} route model
     * (i.e. the application belongs to one of their jobs).
     * Must run AFTER job.poster so $user->jobPoster is guaranteed to exist.
     *
     * Use on any route that binds {application} and needs ownership:
     *   show, updateStatus
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User $user */
        $user        = $request->user();
        $application = $request->route('application');

        if (!$application || (int) $application->jobPost->job_poster_id !== (int) $user->jobPoster->id) {
            abort(403, 'You do not have access to this application.');
        }

        return $next($request);
    }
}