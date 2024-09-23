<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', function(Request $request) {
    return [
        'message' => 'ok'
    ];
});

Route::post('/login', function(Request $request) {
    return [
        'pk' => 'dsadas'
    ];
});
