<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;
use App\Jobs\MoveCarsJob;
use Illuminate\Http\JsonResponse;

class CarMovementController extends Controller
{
    public function start(): JsonResponse
    {
        MoveCarsJob::dispatch();

        return response()->json([
            'message' => 'Car movement started!'
        ]);
    }
}
