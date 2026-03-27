<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Routes are split into separate files for clarity.
| Each file is loaded below.
*/

require __DIR__ . '/auth.php';
require __DIR__ . '/profile.php';
require __DIR__ . '/jobs.php';
require __DIR__ . '/applications.php';

// Root redirect
Route::get('/', function () {
    return redirect()->route('jobs.index');
})->name('home');

// Dashboard redirect
Route::get('/dashboard', function () {
    return redirect()->route('jobs.index');
})->middleware(['auth', 'verified'])->name('dashboard');