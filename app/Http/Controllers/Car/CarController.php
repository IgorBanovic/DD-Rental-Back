<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarCollection;
use App\Http\Services\CarService;

class CarController extends Controller
{
    public function index(CarService $carService, array $dates)
    {
        return new CarCollection($carService->availableCarsForDates($dates));
    }
}
