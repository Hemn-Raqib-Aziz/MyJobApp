<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobPostController;

/*
|--------------------------------------------------------------------------
| Job Post Routes
|--------------------------------------------------------------------------
| Browsing, creating, editing, deleting, saving/unsaving jobs.
*/

// Public
Route::get('/jobs', [JobPostController::class, 'index'])->name('jobs.index');
Route::get('/jobs/saved', [JobPostController::class, 'savedJobs'])->name('jobs.saved');
Route::get('/jobs/{jobPost}', [JobPostController::class, 'show'])->name('jobs.show');

// Auth + verified
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/jobs/create', [JobPostController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [JobPostController::class, 'store'])->name('jobs.store');

    Route::get('/my-jobs', [JobPostController::class, 'myJobs'])->name('jobs.mine');

    Route::get('/jobs/{jobPost}/edit', [JobPostController::class, 'edit'])->name('jobs.edit');
    Route::put('/jobs/{jobPost}', [JobPostController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{jobPost}', [JobPostController::class, 'destroy'])->name('jobs.destroy');

    // Save / unsave
    Route::post('/jobs/{id}/save', [JobPostController::class, 'saveJob'])->name('jobs.save');
    Route::post('/jobs/{id}/unsave', [JobPostController::class, 'unsaveJob'])->name('jobs.unsave');
});