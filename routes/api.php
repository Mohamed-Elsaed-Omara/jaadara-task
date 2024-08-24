<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\StatsController;
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
// authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    //email verification routes
    Route::post('/verify', [EmailVerificationController::class, 'verifyCode']);
    //post routes
    Route::resource('posts',PostController::class);
    //get posts of current user
    Route::get('posts-of-user', [PostController::class, 'getPostsOfUser']);
    //stats routes
    Route::get('stats', StatsController::class);
});



