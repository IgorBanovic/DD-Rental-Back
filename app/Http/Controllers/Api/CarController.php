<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Rules\MoreThan24H;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Car::all());
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'type' => 'required|in:coupe,limousine,SUV',
            'brand' => 'required|in:Volkswagen,Skoda',
            'year' => 'required|numeric|min:2000|max:' . date('Y'),
            'price' => 'required|numeric',
            'status' => 'required|in:returned,in use,reserved',
            'description' => 'required|string|min:50|max:250',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if(!$request->hasFile('image')){
            $car = new Car($request->all());
        }else{
            $imageName = $this->storeImage($request);
            $car = $this->createCar($request, $imageName);
        }
        $car->save();

        return response()->json($car, 201);
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
            'type' => 'required|in:coupe,limousine,SUV',
            'brand' => 'required|in:Volkswagon,Skoda',
            'year' => 'required|integer|min:2000|max:' . date('Y'),
            'price' => 'required|numeric',
            'status' => 'required|in:returned,in use,reserved',
            'description' => 'required|string|min:50|max:250',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]));

        $imageName = $this->storeImage($request);
        $car->update(['image' => 'images/'.$imageName]);

        return response()->json($car);
    }

    public function updateStatus(Request $request, Car $car): JsonResponse
    {
        $car->update($request->validate([
            'status' => 'required|in:returned,in use,reserved'
        ]));

        return response()->json($car);
    }

    public function destroy(Car $car): JsonResponse
    {
        $car->delete();
        return response()->json(['message' => 'Car deleted successfully'], 204);
    }

    public function getReviews(Car $car): JsonResponse
    {
        return response()->json($car->reviews);
    }

    public function availableCarsForDates(Request $request): JsonResponse
    {
        $request->validate([
            'start' => ['required', 'date', new MoreThan24H()],
            'end' => 'required|date|after:start',
        ]);
        $start = Carbon::parse($request->start);
        $end = Carbon::parse($request->end);
        $cars = Car::all();
        $filteredCars = [];

        foreach ($cars as $car) {
            foreach ($car->reservations as $reservation) {
                if(($start->between($reservation->start_date, $reservation->end_date)) ||
                    ($end->between($reservation->start_date, $reservation->end_date)))
                {
                    continue 2;
                }
            }
                $filteredCars[] = $car->withoutRelations();
        }
        return response()->json($filteredCars);
    }
}
