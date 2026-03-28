<?php

use App\Http\Middleware\EnsureApplicationOwner;
use App\Http\Middleware\EnsureJobOwner;
use App\Http\Middleware\EnsureJobPoster;
use App\Http\Middleware\EnsureJobSeeker;
use App\Http\Middleware\EnsureProfileComplete;
use App\Http\Middleware\PreventApplyingToExpiredJobs;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\TrackLastSeen;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // Global — runs on every request
        $middleware->append(PreventBackHistory::class);
        
        // Web group — runs on every web request
        $middleware->appendToGroup('web', TrackLastSeen::class);
        
        // Named aliases for use in route files
        $middleware->alias([
            'job.seeker'        => EnsureJobSeeker::class,
            'job.poster'        => EnsureJobPoster::class,
            'profile.complete'  => EnsureProfileComplete::class,
            'job.owner'         => EnsureJobOwner::class,
            'app.owner'         => EnsureApplicationOwner::class,
            'profile.incomplete'=> RedirectIfAuthenticated::class,
            'job.not_expired'   => PreventApplyingToExpiredJobs::class,
            ]);
            // ->withMiddleware(function (Middleware $middleware): void {
                // $middleware->alias([
                //     'profile.complete' => EnsureProfileComplete::class,
                //     'job.seeker'  => EnsureJobSeeker::class,
                //     'job.poster'  => EnsureJobPoster::class,
                //     'job.owner'  => EnsureJobOwner::class,
                //     'app.owner'  => EnsureApplicationOwner::class,
                //     'job.not_expired'  => PreventApplyExpired::class,
                //     'profile.incomplete'  => RedirectIfProfileDone::class,
                // ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
