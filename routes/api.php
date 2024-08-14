<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\AuthController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/items', [ApiController::class, 'index']);
    Route::get('/items/{id}', [ApiController::class, 'show']);
    Route::post('/items', [ApiController::class, 'store']);
    Route::put('/items/{id}', [ApiController::class, 'update']);
    Route::delete('/items/{id}', [ApiController::class, 'destroy']);

    Route::get('/contacts', [ApiController::class, 'contacts']);
});