<?php

use App\Http\Middleware\EnsureApplicationOwner;
use App\Http\Middleware\EnsureJobOwner;
use App\Http\Middleware\EnsureJobPoster;
use App\Http\Middleware\EnsureJobSeeker;
use App\Http\Middleware\EnsureProfileComplete;
use App\Http\Middleware\PreventApplyingToExpiredJobs;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\RedirectIfProfileComplete;
use App\Http\Middleware\TrackLastSeen;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

/*
|--------------------------------------------------------------------------
| Notes on middleware NOT registered here
|--------------------------------------------------------------------------
|
| RedirectIfAuthenticated — drop-in replacement, NO registration needed.
|   Drop the file in app/Http/Middleware/ and Laravel automatically uses
|   it instead of the framework's own class (same namespace + class name).
|
| RedirectIfProfileComplete — registered below as alias 'profile.incomplete'
|   Used on /setup-profile routes to stop duplicate profile creation.
*/

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // ── Global — runs on every single request ─────────────────────────────
        // PreventBackHistory adds no-cache headers so users can't hit the
        // browser Back button and see a cached page after logging out.
        $middleware->append(PreventBackHistory::class);

        // ── Web group — runs on every web request ─────────────────────────────
        // TrackLastSeen updates users.last_seen_at once every 5 minutes.
        // Requires: $table->timestamp('last_seen_at')->nullable() in migration
        // and 'last_seen_at' in User $fillable.
        $middleware->appendToGroup('web', TrackLastSeen::class);

        // ── Named aliases — used in route files ───────────────────────────────
        $middleware->alias([

            // Role gates
            'job.seeker'         => EnsureJobSeeker::class,
            'job.poster'         => EnsureJobPoster::class,

            // Profile flow
            'profile.complete'   => EnsureProfileComplete::class,   // redirect to setup if no profile
            'profile.incomplete' => RedirectIfProfileComplete::class, // redirect away from setup if already done

            // Ownership checks (run AFTER job.poster so jobPoster is guaranteed)
            'job.owner'          => EnsureJobOwner::class,          // poster owns {jobPost}
            'app.owner'          => EnsureApplicationOwner::class,  // poster owns {application}

            // Deadline guard (run AFTER job.seeker)
            'job.not_expired'    => PreventApplyingToExpiredJobs::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();