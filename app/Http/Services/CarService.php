<?php

namespace App\Http\Services;

use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class CarService
{
    public function index(): Collection
    {
        return Car::where('status', '===',  'returned')->get();
    }

    public function store(array $data): Car
    {
        $car = new Car($data);
        $path = $data['image']->store('images', 'public');

        $car->image = $path;
        $car->save();
        return $car;
    }

    public function update(array $data, Car $car): Car
    {
        $car->update(collect($data)->except('image')->toArray());
        $path = $data['image']->store('images', 'public');
        Storage::disk('public')->delete($car->image);

        $car->image = $path;
        $car->save();
        return $car;
    }

    public function destroy(Car $car): void
    {
        $car->delete();
    }

    public function getReviews(Car $car)
    {
        return $car->reviews;
    }

    public function availableCarsForDates(array $data): array
    {
        $start = Carbon::parse($data['start']);
        $end = Carbon::parse($data['end']);
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
        return $filteredCars;
    }
}
