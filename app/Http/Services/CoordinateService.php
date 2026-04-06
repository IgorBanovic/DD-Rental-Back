<?php

namespace App\Http\Services;

use App\Models\Car;
use App\Models\Coordinate;
use Exception;
use Illuminate\Support\Collection;

class CoordinateService
{
    public function index(Car $car): Collection
    {
        return Coordinate::with('car')->where('car_id', $car->id)->get();
    }

    /**
     * @throws Exception
     */
    public function store(array $data): Coordinate
    {
        $coordinate = new Coordinate($data);
        if(!$coordinate->save()) {
            throw new Exception('Error saving coordinate');
        }
        return $coordinate;
    }
}
