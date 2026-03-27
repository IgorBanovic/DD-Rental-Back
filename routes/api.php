<?php

use App\Http\Controllers\Car\CarController as CarController;
use App\Http\Controllers\Car\CarReviewsController;
use App\Http\Controllers\CarController as CarAdminController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserReservationsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('/cars', CarAdminController::class)->except(['index', 'show']);
    Route::apiResource('/users', UserController::class);
    Route::apiResource('/reservations', ReservationController::class);
    Route::apiResource('/reviews', ReviewController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/{user}/reservations', [UserReservationsController::class, 'index']);
    Route::apiResource('/reservations', ReservationController::class)->except('index');
    Route::apiResource('/reviews', ReviewController::class);
});

require __DIR__.'/auth.php';
Route::get('/cars/available', [CarController::class, 'index']);
Route::get('/cars/{car}/reviews', [CarReviewsController::class, 'index']);
Route::get('/cars/', [CarAdminController::class, 'index']);
Route::get('/cars/{car}/', [CarAdminController::class, 'show']);
