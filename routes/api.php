<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CarController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/users')->controller(UserController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{user}', 'show');
    Route::put('/{user}', 'update');
    Route::delete('/{user}', 'destroy');
});

Route::prefix('/cars')->controller(CarController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{car}', 'show');
    Route::put('/{car}', 'update');
    Route::delete('/{car}', 'destroy');
    Route::put('/status/{car}', 'updateStatus');
});

Route::prefix('/reservations')->controller(ReservationController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{reservation}', 'show');
    Route::put('/{reservation}', 'update');
    Route::delete('/{reservation}', 'destroy');
});

Route::prefix('/reviews')->controller(ReviewController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{review}', 'show');
    Route::put('/{review}', 'update');
    Route::delete('/{review}', 'destroy');
});
