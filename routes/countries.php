<?php

use Illuminate\Routing\Route;
use App\Http\Controllers\CountryController;

Route::get('/country/{id}', [CountryController::class, 'show'])->name('country.show');
