<?php

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me/profile', [ProfileController::class, 'getMyProfile']);
    Route::post('/me/profile/update', [ProfileController::class, 'updateMyProfile']);

    Route::get('/users', [UserController::class, 'getUsers']);
    Route::get('/user/{id}', [UserController::class, 'getUserProfile']);

    Route::apiResource('/posts', PostController::class);
});

//Posts CRUD

//New Feed

//Comments

//React
