<?php

use App\Http\Controllers\LoanOfferController;

Route::get('/loan-offers', [LoanOfferController::class, 'index']);
Route::post('/loan-offers', [LoanOfferController::class, 'store']);

Route::patch('/loan-offers/{offer}', [LoanOfferController::class, 'update']);
Route::delete('/loan-offers/{offer}', [LoanOfferController::class, 'destroy']);