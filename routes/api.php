<?php

use App\Http\Controllers\Car\CarController as CarController;
use App\Http\Controllers\Car\CarReviewsController;
use App\Http\Controllers\CarController as CarAdminController;
use App\Http\Controllers\CarReportController;
use App\Http\Controllers\CoordinateController;
use App\Http\Controllers\UserReportController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserReservationsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('/cars', CarAdminController::class)->except(['index', 'show']);
    Route::apiResource('/users', UserController::class)->except(['show', 'update']);
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::get('/reports/car-performance', [CarReportController::class, 'carPerformance']);
    Route::get('/reports/car-performance/download', [CarReportController::class, 'downloadCarPerformancePdf']);
    Route::get('/reports/customer-satisfaction', [UserReportController::class, 'customerSatisfaction']);
    Route::get('/reports/customer-satisfaction/download', [UserReportController::class, 'downloadCustomerSatisfactionPdf']);
    Route::apiResource('/coordinates', CoordinateController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/{user}/reservations', [UserReservationsController::class, 'index']);
    Route::apiResource('/reservations', ReservationController::class)->except('index');
    Route::apiResource('/reviews', ReviewController::class);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::put('/users/{user}', [UserController::class, 'update']);
});

require __DIR__ . '/auth.php';
Route::get('/cars/{car}/reviews', [CarReviewsController::class, 'index']);
Route::get('/cars/{start}/{end}', [CarController::class, 'index']);
Route::get('/cars', [CarAdminController::class, 'index']);
Route::get('/cars/{car}', [CarAdminController::class, 'show']);
