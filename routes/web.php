<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('register');
})->name('home.index');

Route::get('/home', function () {
    return Inertia::location('https://idealepatrimoine.com/');
})->name('home.root');

Route::get('dashboard', function () {
    return redirect()->route('profile.edit');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/countries.php';
