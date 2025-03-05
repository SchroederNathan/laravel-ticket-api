<?php

use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// http://localhost:8000/api

// Non-versioned API routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Version 1 API routes
Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->apiResource('tickets', controller: TicketController::class);

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
    // Add other v1-specific routes here
});