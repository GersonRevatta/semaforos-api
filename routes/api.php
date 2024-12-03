<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ReportController;

Route::prefix('v1')->group(function () {
  Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
  });

  Route::middleware('auth:api')->group(function () {
    Route::post('/reports', [ReportController::class, 'createReport']);
    Route::get('/reports/my', [ReportController::class, 'myReports']);
    Route::get('/traffic-lights/nearby', [ReportController::class, 'nearbyTrafficLights']);
  });
});
