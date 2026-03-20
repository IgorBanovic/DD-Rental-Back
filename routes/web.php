<?php

use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/users', [UserController::class, 'index']);
Route::post('/api/users', [UserController::class, 'store']);
Route::get('/api/users/{user}', [UserController::class, 'show']);
Route::put('/api/users/{user}', [UserController::class, 'update']);
Route::delete('/api/users/{user}', [UserController::class, 'destroy']);

Route::get('/api/cars', [CarController::class, 'index']);
Route::post('/api/cars', [CarController::class, 'store']);
Route::get('/api/cars/{car}', [CarController::class, 'show']);
Route::put('/api/cars/{car}', [CarController::class, 'update']);
Route::delete('/api/cars/{car}', [CarController::class, 'destroy']);
Route::put('/api/cars/status/{car}', [CarController::class, 'updateStatus']);

Route::get('/api/reservations', [ReservationController::class, 'index']);
Route::post('/api/reservations', [ReservationController::class, 'store']);
Route::get('/api/reservations/{reservation}', [ReservationController::class, 'show']);
Route::put('/api/reservations/{reservation}', [ReservationController::class, 'update']);
Route::delete('/api/reservations/{reservation}', [ReservationController::class, 'destroy']);

Route::get('/api/reviews', [ReviewController::class, 'index']);
Route::post('/api/reviews', [ReviewController::class, 'store']);
Route::get('/api/reviews/{review}', [ReviewController::class, 'show']);
Route::put('/api/reviews/{review}', [ReviewController::class, 'update']);
Route::delete('/api/reviews/{review}', [ReviewController::class, 'destroy']);
