<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reservation\StoreReservationRequest;
use App\Http\Requests\Reservation\UpdateReservationRequest;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class ReservationController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Reservation::all());
    }

    public function store(StoreReservationRequest $request): JsonResponse
    {
        $reservation = new Reservation();
        $reservation->start_date = $request->start_date;
        $reservation->end_date = $request->end_date;
        $reservation->user_id = $request->user_id;
        $reservation->car_id = $request->car_id;
        $reservation->price = $this->calculatePrice($reservation);
        $reservation->save();
        return response()->json($reservation->withoutRelations(), 201);
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

    public function update(UpdateReservationRequest $request, Reservation $reservation): JsonResponse
    {
        $reservation->start_date = $request->start_date;
        $reservation->end_date = $request->end_date;
        $reservation->user_id = $request->user_id;
        $reservation->car_id = $request->car_id;
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
