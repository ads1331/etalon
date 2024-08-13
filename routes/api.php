<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/items', [ApiController::class, 'index']);
Route::get('/items/{id}', [ApiController::class, 'show']);
Route::post('/items', [ApiController::class, 'store']);
Route::put('/items/{id}', [ApiController::class, 'update']);
Route::delete('/items/{id}', [ApiController::class, 'destroy']);