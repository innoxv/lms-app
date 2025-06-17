<?php

use App\Http\Controllers\LoanOfferController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/loan-offers', [LoanOfferController::class, 'index']);
Route::post('/loan-offers', [LoanOfferController::class, 'store']);
Route::patch('/loan-offers/{offer}', [LoanOfferController::class, 'update']);
Route::delete('/loan-offers/{offer}', [LoanOfferController::class, 'destroy']);

// Registration routes
Route::get('/register', [RegistrationController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [RegistrationController::class, 'register'])->name('register');

// Login routes
Route::get('/login', [RegistrationController::class, 'showLoginForm'])->name('login');
Route::post('/login', [RegistrationController::class, 'login'])->name('login.post');

// Logout route
Route::post('/logout', [RegistrationController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard route (protected by auth middleware)
Route::get('/dashboard', function () {
    return view('dashboard'); // Ensure resources/views/dashboard.blade.php exists
})->name('dashboard')->middleware('auth');