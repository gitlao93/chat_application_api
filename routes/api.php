<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ConvoController;






// public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// protected routes
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::resource('chats', ChatController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/convo', [ConvoController::class, 'index']);
});


