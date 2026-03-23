<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class ReservationController extends Controller
{
    //
    public function index(): Collection
    {
        return Reservation::all();
    }

    public function store(Request $request): JsonResponse
    {
        $reservation = new Reservation($request->validate([
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'price' => 'required|numeric'
        ]));
        $reservation->save();
        return response()->json($reservation);
    }

    public function show(Reservation $reservation): JsonResponse
    {
        return response()->json($reservation);
    }

    public function update(Request $request, Reservation $reservation): JsonResponse
    {
        $reservation->update($request->validate([
            'start_date' => 'sometimes|date|after:now',
            'end_date' => 'sometimes|date|after:start_date',
            'user_id' => 'sometimes|exists:users,id',
            'car_id' => 'sometimes|exists:cars,id',
            'price' => 'sometimes|numeric'
        ]));

        return response()->json($reservation);
    }

    public function destroy(Reservation $reservation): JsonResponse
    {
        $reservation->delete();
        return response()->json(null, 204);
    }
}
