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
    public function index()
    {
        return new CarCollection(Car::all());
    }

    public function store(StoreCarRequest $request, CarService $carService)
    {
        $car = $carService->store($request->all());
        return new CarResource($car);
    }

    public function show(Car $car)
    {
        return new CarResource($car);
    }

    public function update(UpdateCarRequest $request, CarService $carService, Car $car)
    {
        $car = $carService->update($request->all(), $car);
        return new CarResource($car);
    }

    public function destroy(Car $car)
    {
            $car->delete();
            return response()->json(['message' => 'Car has been deleted successfully']);
    }
}
