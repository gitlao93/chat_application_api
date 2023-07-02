<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ConvoController;
use App\Http\Controllers\API\GroupController;
use App\Http\Controllers\API\MessageController;






// public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/store', [AuthController::class, 'store']);

// protected routes
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::apiResource('message', MessageController::class);
    Route::apiResource('users', UserController::class);
    Route::post('message/{id}', [MessageController::class, 'store']);
    Route::get('user-conversation/{id}', [MessageController::class, 'showConvoWithUser']);
    Route::get('conversation/{id}', [MessageController::class, 'conversation']);
    Route::apiResource('convo', ConvoController::class);
    Route::apiResource('group', GroupController::class);
    Route::apiResource('group-members', GroupController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});
