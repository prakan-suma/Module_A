<?php

use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth
Route::post('/v1/user/signup', [AuthController::class, 'signup']);
Route::post('/v1/user/signin', [AuthController::class, 'signin']);
Route::post('/v1/user/signout', [AuthController::class, 'signout']);

Route::middleware('token')->group(function(){
});

// User
Route::get('/v1/user/{username}', [UserController::class, 'profile']);


// Game
Route::get('/v1/games', [GameController::class, 'index']);
Route::get('/v1/games/uploaded', [GameController::class, 'uploaded']);
Route::post('/v1/games', [GameController::class, 'store']);
Route::post('/v1/games/update', [GameController::class, 'update']);
