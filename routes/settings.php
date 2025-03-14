<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\PasswordController;

Route::middleware('auth')->group(function () {
    // Route::redirect('settings', '/settings/profile');

    Route::get('settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('settings/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('settings/password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('settings/password', [PasswordController::class, 'update'])->name('password.update');

    Route::get('settings/loan-request', [LoanController::class, 'edit'])->name('loan.edit');
    Route::post('settings/loan-request', [LoanController::class, 'store'])->name('loan.store');
    Route::post('loans/{loan}/verify', [LoanController::class, 'verifyCode'])->name('loan.code.verify');
    Route::post('loans/{loan}/approve', [LoanController::class, 'approveLoan'])->name('loan.approve');

    Route::get('settings/appearance', function () {
        return Inertia::render('settings/Appearance');
    })->name('appearance');
});
