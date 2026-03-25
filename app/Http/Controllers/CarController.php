<?php

namespace App\Http\Controllers;

use App\Http\Requests\Car\StoreCarRequest;
use App\Http\Requests\Car\UpdateCarRequest;
use App\Http\Requests\DateRequest;
use App\Http\Resources\CarCollection;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        return new CarCollection(Car::all());
    }

    public function store(StoreCarRequest $request)
    {
        if(!$request->hasFile('image')){
            $car = new Car($request->all());
        }else{
            $imageName = $this->storeImage($request);
            $car = $this->createCar($request, $imageName);
        }
        $car->save();

        return new CarResource($car);
    }

    public function createCar(StoreCarRequest $request, string $imageName): Car
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

    public function show(Car $car)
    {
        return new CarResource($car);
    }

    public function update(UpdateCarRequest $request, Car $car)
    {
        $imageName = $this->storeImage($request);
        $car->update(['image' => 'images/'.$imageName]);

        return new CarResource($car);
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

    public function availableCarsForDates(DateRequest $request)
    {
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
        return new CarCollection($filteredCars);
    }
}
