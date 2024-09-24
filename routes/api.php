<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->prefix('/users')->group(function() {
    Route::post('/login', 'login');
    Route::post('/register', 'register');

    Route::middleware('auth:sanctum')->group(function() {
        Route::get('', 'fetchProfile');
        Route::put('', 'update');
    });
});
