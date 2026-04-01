<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarCollection;
use App\Http\Services\CarService;
use App\Rules\MoreThan24H;
use Validator;

class CarController extends Controller
{
    public function index(CarService $carService, String $start, String $end)
    {
        $validator = Validator::make(
            compact('start', 'end'),
            [
                'start' => ['required', 'date', new MoreThan24H()],
                'end' => 'required|date|after_or_equal:start',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        return new CarCollection($carService->availableCarsForDates($start, $end));
    }
}
