<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobPostController;

/*
|--------------------------------------------------------------------------
| Job Post Routes
|--------------------------------------------------------------------------
| Static routes MUST come before the {jobPost} wildcard.
*/

// ── Public ──────────────────────────────────────────────────────────────
Route::get('/jobs', [JobPostController::class, 'index'])->name('jobs.index');

// ── Saved jobs — any authenticated user (seeker OR poster) ──────────────
Route::get('/jobs/saved', [JobPostController::class, 'savedJobs'])
    ->middleware(['auth', 'verified', 'profile.complete'])
    ->name('jobs.saved');

// ── Job poster only (static, before wildcard) ────────────────────────────
Route::middleware(['auth', 'verified', 'profile.complete', 'job.poster'])->group(function () {
    Route::get('/jobs/create', [JobPostController::class, 'create'])->name('jobs.create');
    Route::post('/jobs',       [JobPostController::class, 'store'])->name('jobs.store');
    Route::get('/my-jobs',     [JobPostController::class, 'myJobs'])->name('jobs.mine');
});

// ── Save / unsave — any authenticated user (seeker OR poster) ────────────
Route::middleware(['auth', 'verified', 'profile.complete'])->group(function () {
    Route::post('/jobs/{id}/save',   [JobPostController::class, 'saveJob'])->name('jobs.save');
    Route::post('/jobs/{id}/unsave', [JobPostController::class, 'unsaveJob'])->name('jobs.unsave');
});

// ── Wildcard: public show (must be last) ─────────────────────────────────
Route::get('/jobs/{jobPost}', [JobPostController::class, 'show'])->name('jobs.show');

// ── Wildcard: poster edit/update/delete ──────────────────────────────────
Route::middleware(['auth', 'verified', 'profile.complete', 'job.poster'])->group(function () {
    Route::get('/jobs/{jobPost}/edit',  [JobPostController::class, 'edit'])->name('jobs.edit');
    Route::put('/jobs/{jobPost}',       [JobPostController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{jobPost}',    [JobPostController::class, 'destroy'])->name('jobs.destroy');
});