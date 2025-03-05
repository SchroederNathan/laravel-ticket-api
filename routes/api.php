<?php

use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\AuthController;
use App\Models\Ticket;
use Illuminate\Support\Facades\Route;

// http://localhost:8000/api

// Non-versioned API routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Version 1 API routes
Route::prefix('v1')->group(function () {
    Route::apiResource('tickets', controller: TicketController::class);

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    // Add other v1-specific routes here
});