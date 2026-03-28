<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TrackLastSeen
{
    /**
     * Update the authenticated user's last_seen_at once every 5 minutes.
     * Uses a cache lock so we don't hit the DB on every single page load.
     *
     * Prerequisites:
     *   1. Migration: $table->timestamp('last_seen_at')->nullable();
     *   2. User model: add 'last_seen_at' to $fillable.
     *
     * Register in the global web middleware group (no alias needed):
     *   // Laravel 11 — bootstrap/app.php
     *   $middleware->appendToGroup('web', TrackLastSeen::class);
     *
     *   // Laravel 10 — Kernel.php $middlewareGroups['web']
     *   \App\Http\Middleware\TrackLastSeen::class,
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $userId   = Auth::id();
            $cacheKey = "last_seen:{$userId}";

            if (!Cache::has($cacheKey)) {
                Auth::user()->update(['last_seen_at' => now()]);
                Cache::put($cacheKey, true, now()->addMinutes(5));
            }
        }

        return $next($request);
    }
}