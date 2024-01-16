<?php

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ReactController;
use App\Http\Controllers\User\UserController;
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
    //Profile
    Route::get('/me/profile', [ProfileController::class, 'getMyProfile']);
    Route::post('/me/profile/update', [ProfileController::class, 'updateMyProfile']);

    //Other User
    Route::get('/users', [UserController::class, 'getUsers']);
    Route::get('/user/{id}', [UserController::class, 'getUserProfile']);

    //Topic

    //Post
    Route::apiResource('/posts', PostController::class);

    //React
    Route::post('/posts/{id}/react', [ReactController::class, 'addReact']);
    Route::post('/react/{id}/remove', [ReactController::class, 'removeReact']);

    //Comments
    Route::post('/posts/{id}/comment', [CommentController::class, 'addComment']);
    Route::post('/comment/{id}/remove', [CommentController::class, 'removeComment']);


    //New Feed


    //Follow

});
