<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

// ── Profile setup (post-registration, before email verified) ─────────────
Route::get('/setup-profile', function (\Illuminate\Http\Request $request) {
    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ($user->jobSeeker || $user->jobPoster) {
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }
        return redirect()->route('jobs.index');
    }

    return app(ProfileController::class)->setupForm($request);
})->middleware('auth')->name('profile.setup');

Route::post('/setup-profile', [ProfileController::class, 'store'])
    ->middleware('auth')
    ->name('profile.store');

// ── Job poster account ────────────────────────────────────────────────────
Route::middleware(['auth', 'verified', 'profile.complete', 'job.poster'])->group(function () {
    Route::get('/account',    [ProfileController::class, 'showAccount'])->name('account.show');
    Route::put('/account',    [ProfileController::class, 'updateAccount'])->name('account.update');
    Route::delete('/account', [ProfileController::class, 'deleteAccount'])->name('account.delete');
});

// ── Job seeker account ────────────────────────────────────────────────────
Route::middleware(['auth', 'verified', 'profile.complete', 'job.seeker'])->group(function () {
    Route::get('/seeker/account',    [ProfileController::class, 'showSeekerAccount'])->name('seeker.account.show');
    Route::put('/seeker/account',    [ProfileController::class, 'updateSeekerAccount'])->name('seeker.account.update');
    Route::delete('/seeker/account', [ProfileController::class, 'deleteSeekerAccount'])->name('seeker.account.delete');
    Route::post('/seeker/subscribe', [ProfileController::class, 'toggleSubscription'])->name('seeker.subscribe');
});

// ── Public poster profile ─────────────────────────────────────────────────
Route::get('/poster/{jobPoster}', [ProfileController::class, 'showPosterProfile'])->name('poster.profile');