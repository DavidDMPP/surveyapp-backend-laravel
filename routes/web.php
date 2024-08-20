<?php

use Illuminate\Support\Facades\Route;

// Rute Web Dasar
Route::get('/', function () {
    return 'Welcome to Survey App API!';
});

// Rute Filament (jika menggunakan Filament)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});