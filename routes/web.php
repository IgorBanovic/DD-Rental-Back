<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//User endpoints
Route::get('/api/users', [UserController::class, 'index']);
Route::post('/api/users', [UserController::class, 'store']);
Route::get('/api/users/{user}', [UserController::class, 'show']);
Route::put('/api/users/{user}', [UserController::class, 'update']);
Route::delete('/api/users/{user}', [UserController::class, 'destroy']);

//Cars endpoints
Route::get('/api/cars', [CarController::class, 'index']);
Route::post('/api/cars', [CarController::class, 'store']);
Route::get('/api/cars/{car}', [CarController::class, 'show']);
Route::put('/api/cars/{car}', [CarController::class, 'update']);
Route::delete('/api/cars/{car}', [CarController::class, 'destroy']);
Route::put('/api/statusCar/{car}', [CarController::class, 'updateStatus']);
