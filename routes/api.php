<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/categories',                        [CategoryController::class, 'index']);
    Route::post('/categories',                       [CategoryController::class, 'store']);
    Route::get('/categories/{category}',             [CategoryController::class, 'show']);
    Route::put('/categories/{category}',             [CategoryController::class, 'update']);
    Route::delete('/categories/{category}',          [CategoryController::class, 'destroy']);
    Route::get('/products/{product}/categories',     [CategoryController::class, 'byProduct']);

});
