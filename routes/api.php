<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/loans/{loan}', [App\Http\Controllers\LoanController::class, 'show']);
Route::get('/loans/get-latest-pending', [App\Http\Controllers\LoanController::class, 'getLatestPendingLoan']);
