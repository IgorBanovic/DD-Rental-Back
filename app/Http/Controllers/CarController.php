<?php

namespace App\Http\Controllers;

use App\Http\Requests\Car\StoreCarRequest;
use App\Http\Requests\Car\UpdateCarRequest;
use App\Models\Car;
use App\Http\Services\CarService;
use App\Http\Resources\CarResource;
use App\Http\Resources\CarCollection;
use Exception;

class CarController extends Controller
{
    public function index()
    {
        return new CarCollection(Car::all());
    }

    public function store(StoreCarRequest $request, CarService $carService)
    {
        try {
            $car = $carService->store($request->validated());
            return new CarResource($car);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function show(Car $car)
    {
        return new CarResource($car);
    }

    public function update(UpdateCarRequest $request, CarService $carService, Car $car)
    {
        try {
            $car = $carService->update($request->validated(), $car);
            return new CarResource($car);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function destroy(Car $car, CarService $carService)
    {
            try{
                $carService->destroy($car);
                return response()->json(['message' => 'Car has been deleted successfully']);
            }catch (Exception $e){
                return response()->json(['error' => $e->getMessage()], $e->getCode());
            }
    }
}
