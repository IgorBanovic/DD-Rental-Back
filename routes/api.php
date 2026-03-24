<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('/users', UserController::class);
Route::resource('/cars', CarController::class);
Route::resource('/reservations', ReservationController::class);
Route::resource('/reviews', ReviewController::class);
