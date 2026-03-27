<?php

use App\Http\Controllers\Car\CarReviewsController;
use App\Http\Controllers\CarController as CarAdminController;
use App\Http\Controllers\Car\CarController as CarController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Car\UserReservationsController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/users/{user}/reservations', [UserReservationsController::class, 'index']);
    Route::apiResource('/reservations', ReservationController::class)->except('index');
});
//for everyone
Route::get('/cars/available', [CarController::class, 'index']);
Route::post('/register', [AuthController::class, 'createUser']);
Route::post('/login', [AuthController::class, 'loginUser']);
Route::get('/cars/{car}/reviews', [CarReviewsController::class, 'index']);
Route::apiResource('/cars', CarAdminController::class)->only(['index', 'show']);
//for admin
Route::apiResource('/cars', CarAdminController::class);
Route::apiResource('/users', UserController::class);
Route::apiResource('/reservations', ReservationController::class);
Route::apiResource('/reviews', ReviewController::class);
