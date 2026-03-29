<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
| Register, login, logout, and email verification.
*/

// Register
Route::middleware('guest')->group(function () {
    Route::get('/register',  [UserController::class, 'create'])->name('register');
    Route::post('/register', [UserController::class, 'store']);
});

// Login
Route::middleware('guest')->group(function () {
    Route::get('/login',  [UserController::class, 'login'])->name('login');
    Route::post('/login', [UserController::class, 'authenticate']);
});

// Logout
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth')->name('logout');

// Email verification notice
Route::get('/email/verify', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();

    // First check if profile is filled
    if (!$user->jobSeeker && !$user->jobPoster) {
        return redirect()->route('profile.setup', ['role' => $user->user_type]);
    }

    if ($user->hasVerifiedEmail()) {
        return redirect()->route('jobs.index');
    }

    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Email verification handler
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('jobs.index');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Resend verification email
Route::post('/email/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');