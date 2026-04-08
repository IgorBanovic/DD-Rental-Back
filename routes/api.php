<?php

use App\Http\Controllers\Car\CarController as CarController;
use App\Http\Controllers\Car\CarMovementController;
use App\Http\Controllers\Car\CarReviewsController;
use App\Http\Controllers\CarController as CarAdminController;
use App\Http\Controllers\CarReportController;
use App\Http\Controllers\CoordinateController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\UserReportController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserReservationsController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('/cars', CarAdminController::class)->except(['index', 'show']);
    Route::apiResource('/users', UserController::class)->except(['show', 'update']);
    Route::apiResource('/reservations', ReservationController::class)->only('index');
    Route::get('/reports/car-performance', [CarReportController::class, 'carPerformance']);
    Route::get('/reports/car-performance/download', [CarReportController::class, 'downloadCarPerformancePdf']);
    Route::get('/reports/customer-satisfaction', [UserReportController::class, 'customerSatisfaction']);
    Route::get('/reports/customer-satisfaction/download', [UserReportController::class, 'downloadCustomerSatisfactionPdf']);
    Route::apiResource('/coordinates', CoordinateController::class);
    Route::apiResource('/cars/start', CarMovementController::class);
    Route::apiResource('/maintenances', MaintenanceController::class);
});

Route::middleware(['auth:sanctum', 'check_blocked'])->group(function () {
    Route::apiResource('/users/{user}/reservations', UserReservationsController::class)->only('index');
    Route::apiResource('/reservations', ReservationController::class)->except('index');
    Route::apiResource('/reviews', ReviewController::class);
    Route::apiResource('/users', UserController::class)->only(['index']);
});

Route::apiResource('/cars/{car}/reviews', CarReviewsController::class)->only('index');
Route::apiResource('/cars/{start}/{end}', CarController::class)->only('index');
Route::apiResource('/cars', CarAdminController::class)->only(['index', 'show']);
