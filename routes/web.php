<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Livewire\Volt\Volt;

Volt::route('/', 'client.index')->name('home');

//AUTH ROUTES
Route::middleware('guest')->group(function () {
    Volt::route('register', 'auth.register')->name('register');
    Volt::route('login', 'auth.login')->name('login');
    Volt::route('forgot-password', 'auth.forgot-password')->name('password.request');
    Volt::route('reset-password/{token}', 'auth.reset-password')->name('password.reset');
});

Route::post('logout', function () {
    Auth::guard('web')->logout();

    Session::invalidate();
    Session::regenerateToken();

    return redirect('/');
})->name('logout');

//Dashboard ROUTES
Route::middleware('auth')->group(function () {
    Volt::route('/dashboard', 'dashboard.index')->name('dashboard');
});
