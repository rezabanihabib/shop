<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('/', 'client.index');

//AUTH ROUTES
Route::middleware('guest')->group(function () {
    Volt::route('register', 'auth.register')->name('register');
    Volt::route('login', 'auth.login')->name('login');
    Volt::route('forgot-password', 'auth.forgot-password')->name('password.request');
    Volt::route('reset-password/{token}', 'auth.reset-password')->name('password.reset');
});

//Dashboard ROUTES
Route::middleware('auth')->group(function () {
    Volt::route('/dashboard', 'dashboard.index')->name('dashboard');
});
