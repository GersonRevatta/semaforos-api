<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->group(function () {
  Route::get('verify-otp', [AuthController::class, 'verifyOtpGet']);
});
