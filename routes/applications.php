<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

// ── Job seeker only ───────────────────────────────────────────────────────
Route::middleware(['auth', 'verified', 'profile.complete', 'job.seeker'])->group(function () {
    Route::get('/jobs/{jobPost}/apply',  [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/jobs/{jobPost}/apply', [ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/my-applications',       [ApplicationController::class, 'myApplications'])->name('applications.mine');
});

// ── Job poster only ───────────────────────────────────────────────────────
Route::middleware(['auth', 'verified', 'profile.complete', 'job.poster'])->group(function () {
    Route::get('/jobs/{jobPost}/applications',       [ApplicationController::class, 'jobApplications'])->name('applications.job');
    Route::get('/applications/{application}',        [ApplicationController::class, 'show'])->name('applications.show');
    Route::put('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.status');
});