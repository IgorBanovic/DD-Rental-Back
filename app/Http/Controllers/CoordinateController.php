<?php

namespace App\Http\Controllers;

use App\Http\Requests\Coordinate\StoreCoordinateRequest;
use App\Http\Services\CoordinateService;
use App\Models\Car;
use App\Models\Coordinate;
use Exception;

class CoordinateController extends Controller
{
    public function index(Car $car, CoordinateService $coordinateService)
    {
        $coordinates = $coordinateService->index($car);
        return response()->json($coordinates);
    }

    public function store(StoreCoordinateRequest $request, CoordinateService $coordinateService)
    {
        try {
            $coordinate = $coordinateService->store($request->validated());
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
        return response()->json($coordinate);
    }

    public function show(Coordinate $coordinate)
    {
        return response()->json($coordinate);
    }
}
