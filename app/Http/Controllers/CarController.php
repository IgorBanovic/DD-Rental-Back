<?php

namespace App\Http\Controllers;

use App\Http\Requests\Car\StoreCarRequest;
use App\Http\Requests\Car\UpdateCarRequest;
use App\Models\Car;
use App\Http\Services\CarService;
use App\Http\Resources\CarResource;
use App\Http\Resources\CarCollection;

class CarController extends Controller
{
    public function index(CarService $carService)
    {
        return new CarCollection($carService->index());
    }
    public function store(StoreCarRequest $request, CarService $carService)
    {
        $car = $carService->store((array)$request);
        return new CarResource($car);
    }

    public function show(Car $car)
    {
        return new CarResource($car);
    }

    public function update(UpdateCarRequest $request, CarService $carService, Car $car)
    {
        $car = $carService->update((array)$request, $car);
        return new CarResource($car);
    }

    public function destroy(Car $car)
    {
            $car->delete();
            return response()->json(['message' => 'Car has been deleted successfully']);
    }
}
