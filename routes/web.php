<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Livewire\Volt\Volt;

//ADMIN ROUTES
Route::middleware(['auth', 'password.confirm'])->prefix('admin/')->name('admin.')->group(function () {
    Route::get('/', 'index')->name('index');
});

//ClIENT ROUTES
Route::prefix('client/')->name('client.')->group(function () {
    Route::get('/', 'index')->name('index');
});

//DASHBOARD ROUTES
Route::middleware(['auth', 'password.confirm'])->prefix('dashboard/')->name('dashboard.')->group(function () {
    Route::get('/', 'index')->name('index');
});

//AUTH ROUTES
Route::middleware('guest')->group(function () {
    Volt::route('/register', 'auth.register')->name('register');
    Volt::route('/login', 'auth.login')->name('login');
    Volt::route('/forgot-password', 'auth.forgot-password')->name('password.request');
    Volt::route('/reset-password/{token}', 'auth.reset-password')->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'auth.verify-email')->name('verification.notice');

    // Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

    Volt::route('confirm-password', 'auth.confirm-password')->name('password.confirm');
});

Route::post('/logout', function () {
    Auth::guard('web')->logout();

    Session::invalidate();
    Session::regenerateToken();

    return redirect('/');
})->name('logout');
