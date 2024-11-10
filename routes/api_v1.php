<?php

use App\Http\Controllers\Api\V1\AuthorController;
use App\Http\Controllers\Api\V1\AuthorTicketsController;
use App\Http\Controllers\Api\V1\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('ticket', TicketController::class)->except(['update']);
    Route::put('ticket/{ticket}', [TicketController::class, 'replace']);

    Route::apiResource('authors', AuthorController::class);
    Route::apiResource('authors.tickets', AuthorTicketsController::class)->except(['update']);
    Route::put('authors/{author}/tickets/{ticket}', [AuthorTicketsController::class, 'replace']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




