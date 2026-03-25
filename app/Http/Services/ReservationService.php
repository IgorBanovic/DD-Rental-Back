<?php

namespace App\Http\Services;

use App\Http\Requests\Reservation\UpdateReservationRequest;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Collection;

class ReservationService
{
    public function index(): Collection
    {
        return Reservation::all();
    }

    public function store(array $data): Reservation
    {
        $reservation = new Reservation($data);
        $reservation->price = $this->calculatePrice($reservation);
        $reservation->save();
        return $reservation;
    }

    private function calculatePrice(Reservation $reservation): float
    {
        $days = ceil(Carbon::parse($reservation->start_date)
            ->diffInDays(Carbon::parse($reservation->end_date)));
        return $days * $reservation->car->price;
    }

    public function show(Reservation $reservation): Reservation
    {
        return $reservation;
    }

    public function update(array $data, Reservation $reservation): Reservation
    {
        $reservation->update($data);
        $reservation->price = $this->calculatePrice($reservation);
        $reservation->save();
        return $reservation;
    }

    /**
     * @throws Exception
     */
    public function destroy(Reservation $reservation): void
    {
        if($reservation->start_date >= now()->addHours(48)) {
            $reservation->delete();
        }
        else{
            throw new Exception('The reservation can not be cancelled in less than 48 hours prior start', 400);
        }
    }
}
