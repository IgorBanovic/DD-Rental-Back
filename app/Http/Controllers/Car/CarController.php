<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;
use App\Http\Requests\DateRequest;
use App\Http\Resources\CarCollection;
use App\Http\Services\CarService;

class CarController extends Controller
{
    public function index(CarService $carService, DateRequest $request)
    {
        return new CarCollection($carService->availableCarsForDates($request->all()));
    }
}
