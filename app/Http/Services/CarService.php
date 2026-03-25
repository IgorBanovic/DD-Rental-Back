<?php

namespace App\Http\Services;

use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CarService
{
    public function index(): Collection
    {
        return Car::all();
    }

    public function store(array $data): Car
    {
        //popraviti logiku za skladistenje slika
        $car = new Car($data);

        if(isset($data['image'])){
            $imageName = time().'.'.$data['image']->extension();
            $data['image']->move(public_path('images'), $imageName);
            $car->image = 'images/'.$imageName;
        }

        $car->save();
        return $car;
    }

    public function show(Car $car): Car
    {
        return $car;
    }

    public function update(array $data, Car $car): Car
    {
        $car->update($data);

        if (isset($data['image'])) {
            $imageName = time().'.'.$data['image']->extension();
            $data['image']->move(public_path('images'), $imageName);
            $car->image = 'images/'.$imageName;
            $car->save();
        }

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
