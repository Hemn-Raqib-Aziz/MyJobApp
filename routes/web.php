<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect()->route('jobs.index');
})->name('home');

// Register
Route::get('/register', [UserController::class, 'create'])->name('register')->middleware('guest');
Route::post('/register', [UserController::class, 'store'])->middleware('guest');

// Login
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [UserController::class, 'authenticate']);

// Logout
Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/dashboard', function () {
    return redirect()->route('jobs.index');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/setup-profile', function (Illuminate\Http\Request $request) {
    /** @var \App\Models\User $user */
    $user = Auth::user();

    // If profile already filled, go to verify email or jobs
    if ($user->jobSeeker || $user->jobPoster) {
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }
        return redirect()->route('jobs.index');
    }

    return app(App\Http\Controllers\ProfileController::class)->setupForm($request);
})->middleware('auth')->name('profile.setup');

Route::post('/setup-profile', [ProfileController::class, 'store'])
    ->middleware('auth')
    ->name('profile.store');










Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('jobs.index'); // 👈 changed from dashboard
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/email/verify', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();

    // First check if profile is filled
    if (!$user->jobSeeker && !$user->jobPoster) {
        return redirect()->route('profile.setup', ['role' => $user->user_type]);
    }

    if ($user->hasVerifiedEmail()) {
        return redirect()->route('jobs.index'); // 👈 changed from dashboard
    }
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Resend verification email
Route::post('/email/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');



Route::get('/jobs', [JobPostController::class, 'index'])->name('jobs.index');
Route::get('/jobs/create', [JobPostController::class, 'create'])->middleware(['auth', 'verified'])->name('jobs.create');
Route::post('/jobs', [JobPostController::class, 'store'])->middleware(['auth', 'verified'])->name('jobs.store');
Route::get('/jobs/{jobPost}', [JobPostController::class, 'show'])->name('jobs.show');

// My posted jobs (job poster only)
Route::get('/my-jobs', [JobPostController::class, 'myJobs'])->middleware(['auth', 'verified'])->name('jobs.mine');
Route::get('/jobs/{jobPost}/edit', [JobPostController::class, 'edit'])->middleware(['auth', 'verified'])->name('jobs.edit');
Route::put('/jobs/{jobPost}', [JobPostController::class, 'update'])->middleware(['auth', 'verified'])->name('jobs.update');
Route::delete('/jobs/{jobPost}', [JobPostController::class, 'destroy'])->middleware(['auth', 'verified'])->name('jobs.destroy');




// Job Poster account management
Route::get('/account', [ProfileController::class, 'showAccount'])->middleware(['auth', 'verified'])->name('account.show');
Route::put('/account', [ProfileController::class, 'updateAccount'])->middleware(['auth', 'verified'])->name('account.update');
Route::delete('/account', [ProfileController::class, 'deleteAccount'])->middleware(['auth', 'verified'])->name('account.delete');



// Job Seeker account management
Route::get('/seeker/account', [ProfileController::class, 'showSeekerAccount'])->middleware(['auth', 'verified'])->name('seeker.account.show');
Route::put('/seeker/account', [ProfileController::class, 'updateSeekerAccount'])->middleware(['auth', 'verified'])->name('seeker.account.update');
Route::delete('/seeker/account', [ProfileController::class, 'deleteSeekerAccount'])->middleware(['auth', 'verified'])->name('seeker.account.delete');
Route::post('/seeker/subscribe', [ProfileController::class, 'toggleSubscription'])->middleware(['auth', 'verified'])->name('seeker.subscribe');






// Job seeker - apply for a job
Route::get('/jobs/{jobPost}/apply', [ApplicationController::class, 'create'])->middleware(['auth', 'verified'])->name('applications.create');
Route::post('/jobs/{jobPost}/apply', [ApplicationController::class, 'store'])->middleware(['auth', 'verified'])->name('applications.store');

// Job seeker - see their applications
Route::get('/my-applications', [ApplicationController::class, 'myApplications'])->middleware(['auth', 'verified'])->name('applications.mine');

// Job poster - see applications for a job
Route::get('/jobs/{jobPost}/applications', [ApplicationController::class, 'jobApplications'])->middleware(['auth', 'verified'])->name('applications.job');

// Job poster - see single application
Route::get('/applications/{application}', [ApplicationController::class, 'show'])->middleware(['auth', 'verified'])->name('applications.show');

// Job poster - update application status
Route::put('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->middleware(['auth', 'verified'])->name('applications.status');


// Public job poster profile
Route::get('/poster/{jobPoster}', [ProfileController::class, 'showPosterProfile'])->name('poster.profile');
