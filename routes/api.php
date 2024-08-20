<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SurveyController;

// Rute Autentikasi
Route::post('/login', [AuthController::class, 'login']);
Route::get('/login-test', [AuthController::class, 'loginTest']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Rute Survey (Protected)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/surveys', [SurveyController::class, 'index']);
    Route::post('/surveys', [SurveyController::class, 'store']);
    Route::get('/surveys/{survey}', [SurveyController::class, 'show']);
    Route::put('/surveys/{survey}', [SurveyController::class, 'update']);
    Route::delete('/surveys/{survey}', [SurveyController::class, 'destroy']);
});

// Fallback route untuk menangani 404
Route::fallback(function () {
    return response()->json(['message' => 'Not Found'], 404);
});