<?php

use App\Http\Controllers\CarController as CarAdminController;
use App\Http\Controllers\Car\CarController as CarController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController as ReviewAdminController;
use App\Http\Controllers\Car\ReviewController as ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/{car}/reviews', [ReviewController::class, 'index']);
});
//for everyone
Route::get('/cars/{dates}/availableCars', [CarController::class, 'index']);
Route::post('/register', [AuthController::class, 'createUser']);
Route::post('/login', [AuthController::class, 'loginUser']);

//for admin
Route::apiResource('/cars', CarAdminController::class);
Route::apiResource('/users', UserController::class);
Route::apiResource('/reservations', ReservationController::class);
Route::apiResource('/reviews', ReviewAdminController::class);
