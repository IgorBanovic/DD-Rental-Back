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

        if (isset($data['image'])) {
            Storage::disk('public')->delete($car->image);
            $path = $data['image']->store('images', 'public');
            $car->image = $path;

            if(!$car->save()){
                throw new Exception('Error saving car', 500);
            }
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

    public function availableCarsForDates(string $start, string $end): array
    {
        $start = Carbon::parse($start);
        $end = Carbon::parse($end);

        $cars = Car::availableForDates($start, $end)->get();

        return $cars->toArray();
    }
}
