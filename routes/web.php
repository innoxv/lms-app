<?php

use App\Http\Controllers\LoanOfferController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/loan-offers', [LoanOfferController::class, 'index']);
Route::post('/loan-offers', [LoanOfferController::class, 'store'])->name('loan-offers.store');
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

// Dynamic dashboard route
Route::get('/dashboard', [RegistrationController::class, 'showDashboard'])->name('dashboard')->middleware('auth');