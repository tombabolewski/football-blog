<?php

use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthenticationController;
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

Route::middleware('api')->name('api.')
    ->group(function () {
        // Accessible without authentication
        Route::prefix('auth')->name('auth.')
            ->group(function () {
                Route::post('login', [AuthenticationController::class, 'login'])->name('login');
                Route::post('register', [AuthenticationController::class, 'register'])->name('register');
            });

        // Accessible after authentication
        Route::middleware('auth:api')->group(function () {
            Route::prefix('auth')->name('auth.')
                ->group(function () {
                    Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
                });

            Route::apiResource('user', UserController::class);
            Route::apiResource('post', PostController::class);
            Route::apiResource('image', ImageController::class)->only(['destroy']);
        });
    });
