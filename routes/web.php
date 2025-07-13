<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('/', 'client.index');

//AUTH ROUTES
Route::middleware('guest')->group(function () {
    Volt::route('register', 'auth.register')->name('register');
});
