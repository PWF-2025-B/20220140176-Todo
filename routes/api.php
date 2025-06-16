<?php

use App\Http\Controllers\API\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/login', [\App\Http\Controllers\API\AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [\App\Http\Controllers\API\AuthController::class, 'logout']);
    // Tambahkan rute lain yang memerlukan otentikasi admin di sini
    //Route::get('/todos/search', [\App\Http\Controllers\API\TodoController::class, 'search']);
    Route::get('/todos/search', [TodoController::class, 'search']);
    Route::apiResource('/todos', \App\Http\Controllers\API\TodoController::class);
});