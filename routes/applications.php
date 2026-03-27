<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
| Job seeker applications and job poster application management.
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // Job seeker — apply
    Route::get('/jobs/{jobPost}/apply', [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/jobs/{jobPost}/apply', [ApplicationController::class, 'store'])->name('applications.store');

    // Job seeker — view own applications
    Route::get('/my-applications', [ApplicationController::class, 'myApplications'])->name('applications.mine');

    // Job poster — view applications for a job
    Route::get('/jobs/{jobPost}/applications', [ApplicationController::class, 'jobApplications'])->name('applications.job');

    // Job poster — view single application
    Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');

    // Job poster — update application status
    Route::put('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.status');
});