<?php

namespace App\Http\Services;

use App\Models\Reservation;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;

class ReservationService
{
    public function index(): Collection
    {
        return Reservation::where('start_date', '>=', now())->get();
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

    /**
     * @throws Exception
     */
    public function update(array $data, Reservation $reservation): Reservation
    {
        if($reservation->start_date > now()){
            $reservation->update($data);
            $reservation->price = $this->calculatePrice($reservation);
            $reservation->save();
            return $reservation;
        }else{
            throw new Exception("The reservation cannot be updated after it's already started", 403);
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(Reservation $reservation): void
    {
        if($reservation->start_date >= now()->addHours(48)) {
            $reservation->delete();
        } else{
            throw new Exception('The reservation cannot be cancelled in less than 48 hours prior start', 403);
        }
    }
}
