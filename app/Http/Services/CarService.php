<?php

namespace App\Http\Services;

use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Exception;

class CarService
{
    /**
     * @throws Exception
     */
    public function store(array $data): Car
    {
        $car = new Car($data);
        $path = $data['image']->store('images', 'public');

        $car->image = $path;
        if(!$car->save()) {
            throw new Exception('Error saving car', 500);
        }
        return $car;
    }

    /**
     * @throws Exception
     */
    public function update(array $data, Car $car): Car
    {
        if(!$car->update(collect($data)->except('image')->toArray())){
            throw new Exception('Error updating car', 500);
        }
        $path = $data['image']->store('images', 'public');
        Storage::disk('public')->delete($car->image);

        $car->image = $path;
        if(!$car->save()){
            throw new Exception('Error saving car', 500);
        }
        return $car;
    }

    /**
     * @throws Exception
     */
    public function destroy(Car $car): void
    {
        if(!$car->delete()){
            throw new Exception('Error deleting car', 500);
        }
        Storage::disk('public')->delete($car->image);
    }

    public function availableCarsForDates(array $data): array
    {
        $start = Carbon::parse($data['start']);
        $end = Carbon::parse($data['end']);
        $cars = Car::all();
        $filteredCars = [];

        foreach ($cars as $car) {
            foreach ($car->reservations as $reservation) {
                if($start->between($reservation->start_date, $reservation->end_date) ||
                    $end->between($reservation->start_date, $reservation->end_date) ||
                    ($start <= $reservation->start_date && $end >= $reservation->end_date))
                {
                    continue 2;
                }
            }
            $filteredCars[] = $car->withoutRelations();
        }
        return $filteredCars;
    }
}
