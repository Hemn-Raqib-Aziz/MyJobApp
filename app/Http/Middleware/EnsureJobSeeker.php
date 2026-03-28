<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureJobSeeker
{
    /**
     * Only allow job seekers through.
     * Register alias 'job.seeker' in bootstrap/app.php (L11)
     * or Kernel.php $middlewareAliases (L10).
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