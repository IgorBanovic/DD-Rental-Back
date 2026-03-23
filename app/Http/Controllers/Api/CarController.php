<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class CarController extends Controller
{
    public function index(): Collection
    {
        return Car::all();
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'type' => 'required|in:coupe,limousine,SUV',
            'brand' => 'required|in:Volkswagen,Skoda',
            'year' => 'required|numeric|min:2000|max:' . date('Y'),
            'price' => 'required|numeric',
            'status' => 'required|boolean',
            'description' => 'required|string|min:50|max:250',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if($request->image === NULL){
            $car = new Car($request->all());
        }else{
            $imageName = $this->storeImage($request);
            $car = $this->createCar($request, $imageName);
        }
        $car->save();

        return response()->json($car);
    }

    public function createCar(Request $request, string $imageName): Car
    {
        $car = new Car();
        $car->type = $request->type;
        $car->brand = $request->brand;
        $car->year = $request->year;
        $car->price = $request->price;
        $car->status = $request->status;
        $car->description = $request->description;
        $car->image = 'images/'.$imageName;
        return $car;
    }

    public function storeImage(Request $request): string
    {
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        return $imageName;
    }

    public function show(Car $car): JsonResponse
    {
        return response()->json($car);
    }

    public function update(Request $request, Car $car): JsonResponse
    {
        $car->update($request->validate([
            'type' => 'sometimes|in:coupe,limousine,SUV',
            'brand' => 'sometimes|in:Volkswagon,Skoda',
            'year' => 'sometimes|numeric|min:2000|max:' . date('Y'),
            'price' => 'sometimes|numeric',
            'status' => 'sometimes|boolean:',
            'description' => 'sometimes|string|min:50|max:250',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]));

        if($request->image !== NULL){
            $imageName = $this->storeImage($request);
            $car->update(['image' => 'images/'.$imageName]);
        }

        return response()->json($car);
    }

    public function updateStatus(Request $request, Car $car): JsonResponse
    {
        $car->update($request->validate([
            'status' => 'required|boolean:'
        ]));

        return response()->json($car);
    }

    public function destroy(Car $car): JsonResponse
    {
        $car->delete();
        return response()->json(null, 204);
    }
}
