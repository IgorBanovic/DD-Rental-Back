<?php

namespace App\Http\Services;

use App\Events\MoveCar;
use App\Models\Car;
use Illuminate\Http\JsonResponse;

class CarMovementService
{
    private function move(Car $car): void
    {
        if (!$car->target_latitude || !$car->target_longitude) {

            $next = $car->coordinates()
                ->where('order', $car->target_index + 1)
                ->first();

            if (!$next)
                return;

            $car->target_latitude = $next->latitude;
            $car->target_longitude = $next->longitude;
        }

        $step = 0.0001;

        $latDiff = $car->target_latitude - $car->latitude;
        $lngDiff = $car->target_longitude - $car->longitude;

        $distance = sqrt($latDiff * $latDiff + $lngDiff * $lngDiff);

        if ($distance < $step) {
            $car->latitude = $car->target_latitude;
            $car->longitude = $car->target_longitude;

            $car->target_latitude = null;
            $car->target_longitude = null;

            $car->target_index += 1;
        } else {
            $car->latitude += ($latDiff / $distance) * $step;
            $car->longitude += ($lngDiff / $distance) * $step;
        }

        $car->save();

        event(new MoveCar($car));
    }

    public function moveAll(): JsonResponse
    {
        $cars = Car::where('status', 'in use')->get();

        foreach ($cars as $car) {
            $this->move($car);
        }

        return response()->json('Cars moved successfully');
    }

}
