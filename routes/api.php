<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryAPIController;


Route::controller(AuthController::class)->group(function() {
    Route::post('login', 'login');
    Route::post('register', 'register');
});


Route::middleware('auth:sanctum')->group(function() {
    Route::get('category/index', [CategoryAPIController::class, 'index']);
    Route::get('category/detail/{id}', [CategoryAPIController::class, 'detail']);
    Route::post('category/create', [CategoryAPIController::class, 'store']);
    Route::put('category/update/{id}', [CategoryAPIController::class, 'update']);
    Route::delete('category/delete/{id}', [CategoryAPIController::class, 'destroy']);
    Route::post('user/logout', [AuthController::class, 'logout']);
});
