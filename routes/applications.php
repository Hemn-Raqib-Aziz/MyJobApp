<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

// ── Job seeker only ───────────────────────────────────────────────────────
Route::middleware(['auth', 'verified', 'profile.complete', 'job.seeker', , 'job.not_expired'])->group(function () {
    Route::get('/jobs/{jobPost}/apply',  [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/jobs/{jobPost}/apply', [ApplicationController::class, 'store'])->name('applications.store');
});

// ── Job seeker: own application list — no job.not_expired here ────────────────
Route::middleware(['auth', 'verified', 'profile.complete', 'job.seeker'])->group(function () {
    Route::get('/my-applications', [ApplicationController::class, 'myApplications'])->name('applications.mine');
});

// ── Job poster: application list for one of their jobs ────────────────────────
// job.owner confirms this poster owns the {jobPost}
Route::middleware(['auth', 'verified', 'profile.complete', 'job.poster', 'job.owner'])->group(function () {
    Route::get('/jobs/{jobPost}/applications', [ApplicationController::class, 'jobApplications'])->name('applications.job');
});

// ── Job poster only ───────────────────────────────────────────────────────
Route::middleware(['auth', 'verified', 'profile.complete', 'job.poster', 'app.owner'])->group(function () {
    Route::get('/applications/{application}',        [ApplicationController::class, 'show'])->name('applications.show');
    Route::put('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.status');
});
