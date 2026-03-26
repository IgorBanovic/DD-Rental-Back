<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reservation\StoreReservationRequest;
use App\Http\Requests\Reservation\UpdateReservationRequest;
use App\Http\Resources\ReservationCollection;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Http\Services\ReservationService;
use Exception;

class ReservationController extends Controller
{
    public function index()
    {
        return new ReservationCollection(Reservation::all());
    }

    public function store(StoreReservationRequest $request, ReservationService $reservationService)
    {
        $reservation = $reservationService->store($request);
        return new ReservationResource($reservation);
    }

    public function show(Reservation $reservation)
    {
        return new ReservationResource($reservation);
    }

    public function update(UpdateReservationRequest $request, Reservation $reservation, ReservationService $reservationService)
    {
        $reservation = $reservationService->update($request, $reservation);
        return new ReservationResource($reservation);
    }

    public function destroy(Reservation $reservation, ReservationService $reservationService)
    {
        try{
            $reservationService->destroy($reservation);
            return response()->json(['message' => 'Reservation has been cancelled successfully'], 204);
        }catch (Exception $e){
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
