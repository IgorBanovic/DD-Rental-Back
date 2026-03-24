<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Rules\MoreThan24H;

class ReservationController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Reservation::all());
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'start_date' => ['required', 'date', new MoreThan24H()],
            'end_date' => 'required|date|after:start_date',
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id'
        ]);

        $reservation = $this->createReservation($request);
        $reservation->save();
        return response()->json($reservation->withoutRelations(), 201);
    }

    public function createReservation(Request $request): Reservation
    {
        $reservation = new Reservation();
        $reservation->start_date = $request->start_date;
        $reservation->end_date = $request->end_date;
        $reservation->user_id = $request->user_id;
        $reservation->car_id = $request->car_id;
        $reservation->price = $this->calculatePrice($reservation);
        return $reservation;
    }

    public function calculatePrice(Reservation $reservation): float
    {
        $days = ceil(Carbon::parse($reservation->start_date)
            ->diffInDays(Carbon::parse($reservation->end_date)));
        return $days * $reservation->car->price;
    }

    public function show(Reservation $reservation): JsonResponse
    {
        return response()->json($reservation);
    }

    public function update(Request $request, Reservation $reservation): JsonResponse
    {
        $reservation->update($request->validate([
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id'
        ]));

        $reservation->price = $this->calculatePrice($reservation);
        $reservation->save();
        return response()->json($reservation->withoutRelations());
    }

    public function destroy(Reservation $reservation): JsonResponse
    {
        if($reservation->start_date >= now()->addHours(48)) {
            $reservation->delete();
            return response()->json(['message' => 'Reservation canceled'], 204);
        }
        else{
            return response()->json('Reservations can be cancelled only 48 hours prior start without charge' , 422);
        }
    }
}
