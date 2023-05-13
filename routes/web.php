<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Route;

// Root
Route::get('/', [HomeController::class, 'index']);

// User views
Route::prefix('user')->group(function () {
    Route::get('/signin', [UserController::class, 'signin']);
    Route::get('/signup', [UserController::class, 'signup']);
    Route::get('/{username}', [UserController::class, 'show']);
});

// User auth
Route::prefix('auth')->group(function () {
    Route::post('/signin', [AuthController::class, 'signin']);
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::get('/signout', [AuthController::class, 'signout']);
});

// Admin Control
Route::post('/admin/signin', [AdminAuthController::class, 'signin']);
Route::get('/admin/signout', [AdminAuthController::class, 'signout']);
Route::post('/admin/block', [AdminController::class, 'block']);
Route::get('/admin/unblock/{id}', [AdminController::class, 'unblock']);
Route::get('/admin/delete/{id}', [AdminController::class, 'deleteGame']);
Route::post('/admin/search', [AdminController::class, 'search']);
Route::get('/admin/score/{id}', [AdminController::class, 'score']);
Route::get('/admin/resetscore/{id}', [AdminController::class, 'resetscore']);
Route::get('/admin/deletescore/{id}', [AdminController::class, 'deletescore']);
Route::get('/admin/deleteall/{id}', [AdminController::class, 'deleteall']);

//Admin view
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'signin']);
    Route::get('/admin', [AdminController::class, 'admin']);
    Route::get('/user', [AdminController::class, 'user']);
    Route::get('/game', [AdminController::class, 'game']);
});

// Game
Route::get('/game/control', [GameController::class, 'control']);
Route::get('/game/update/{id}', [GameController::class, 'updateForm']);
Route::post('/game/newversions', [GameController::class, 'update']);
Route::resource('/game', GameController::class);

Route::middleware(['block'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/signin', [UserController::class, 'signin']);
        Route::get('/signup', [UserController::class, 'signup']);
        Route::get('/{username}', [UserController::class, 'show']);
    });

    Route::get('/game/control', [GameController::class, 'control']);
    Route::get('/game/update/{id}', [GameController::class, 'updateForm']);
    Route::post('/game/newversions', [GameController::class, 'update']);
    Route::resource('/game', GameController::class);

    Route::prefix('user')->group(function () {
        Route::get('/signin', [UserController::class, 'signin']);
        Route::get('/signup', [UserController::class, 'signup']);
        Route::get('/{username}', [UserController::class, 'show']);
    });
});
