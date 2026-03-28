<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureJobPoster
{
    /**
     * Only allow job posters through.
     * Register alias 'job.poster' in bootstrap/app.php (L11)
     * or Kernel.php $middlewareAliases (L10).
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