<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CarController extends Controller
{
    //
    public function index(): Collection
    {
        return Car::all();
    }

    public function store(Request $request): JsonResponse
    {
        $car = new Car($request->validate([
            'type' => 'required|in:coupe,limousine,SUV',
            'brand' => 'required|in:Volkswagen,Skoda',
            'year' => 'required|numeric|min:2000|max:' . date('Y'),
            'price' => 'required|numeric',
            'status' => 'required|in:0,1,true,false',
            'description' => 'required|string|min:50|max:250',
            'image' => 'required|string'
        ]));

        $car->save();
        return response()->json($car, 201);
    }

    public function show(Car $car): JsonResponse
    {
        return response()->json($car);
    }

    public function update(Request $request, Car $car): JsonResponse
    {
        $car->update($request->validate([
            'type' => 'in:coupe,limousine,SUV',
            'brand' => 'in:Volkswagon,Skoda',
            'year' => 'numeric|min:2000|max:' . date('Y'),
            'price' => 'numeric',
            'status' => 'in:0,1',
            'description' => 'string|min:50|max:250',
            'image' => 'string'
        ]));

        return response()->json($car);
    }

    public function updateStatus(Request $request, Car $car): JsonResponse
    {
        $car->update($request->validate([
            'status' => 'required|in:0,1'
        ]));

        return response()->json($car);
    }

    public function destroy(Car $car): JsonResponse
    {
        $car->delete();
        return response()->json(null, 204);
    }
}
