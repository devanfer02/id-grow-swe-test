<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)
->prefix('/users')
->group(function() {
    Route::post('/login', 'login');
    Route::post('/register', 'register');

    Route::middleware('auth:sanctum')->group(function() {
        Route::get('', 'fetchProfile');
        Route::put('', 'update');
        Route::delete('', 'delete');
    });
});

Route::controller(ItemController::class)
->prefix('/items')
->middleware('auth:sanctum')
->group(function() {
    Route::get('/', 'fetchAll');
    Route::get('/{id}', 'fetchOne');
    Route::post('', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});
