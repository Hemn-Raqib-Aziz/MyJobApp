<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventBackHistory
{
    /**
     * Global middleware — no alias needed, append directly.
     * Adds no-cache headers so the browser never shows a stale cached page
     * when the user hits Back after logging out.
     *
     * Register globally in bootstrap/app.php (L11):
     *   $middleware->append(PreventBackHistory::class);
     *
     * Or in Kernel.php $middleware array (L10):
     *   \App\Http\Middleware\PreventBackHistory::class,
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        return $response->withHeaders([
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma'        => 'no-cache',
            'Expires'       => 'Sat, 01 Jan 2000 00:00:00 GMT',
        ]);
    }
}