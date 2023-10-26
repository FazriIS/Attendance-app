<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Middleware\AuthApiMiddleware;
use App\Http\Controllers\API\UsersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::post('/users/register', [UsersController::class, 'registerApi']);
Route::post('/users/login', [UsersController::class, 'loginApi']);


Route::middleware(AuthApiMiddleware::class)->group(function() {
    Route::get('/users', [UsersController::class, 'getUserCurrent']);
    Route::patch('/users', [UsersController::class, 'updateUserCurrent']);
    Route::delete('/users/logout', [UsersController::class, 'logout']);
});
