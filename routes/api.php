<?php

use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\V1\AuthorsController;
use App\Http\Controllers\Api\V1\AuthorTicketsController;
use Illuminate\Support\Facades\Route;

// http://localhost:8000/api

// Non-versioned API routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Version 1 API routes
Route::prefix('v1')->group(function () {

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('tickets', controller: TicketController::class)->except(['update']);
        Route::put('tickets/{ticket}', [TicketController::class, 'replace']);
        Route::patch('tickets/{ticket}', [TicketController::class, 'update']);

        Route::apiResource('authors', controller: AuthorsController::class);
        Route::apiResource('authors.tickets', controller: AuthorTicketsController::class)->except(['update']);
        Route::put('authors/{author}/tickets/{ticket}', [AuthorTicketsController::class, 'replace']);
        Route::patch('authors/{author}/tickets/{ticket}', [AuthorTicketsController::class, 'update']);

        Route::get('/user', function (Request $request) {
            return $request->user();
        });


        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});