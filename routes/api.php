<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;






// public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// protected routes
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::resource('chats', ChatController::class);
    Route::get('convo', [ChatController::class, 'convo']);
    Route::get('convo_message/{id}', [ChatController::class, 'convo_message']);
    Route::post('/logout', [AuthController::class, 'logout']);
});


