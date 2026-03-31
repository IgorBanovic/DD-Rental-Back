<?php

namespace App\Http\Services;

use App\Models\Reservation;
use Carbon\Carbon;
use Exception;

class ReservationService
{
    /**
     * @throws Exception
     */
    public function store(array $data): Reservation
    {
        //This function allows double booking, check the last code
        $reservation = new Reservation($data);
        $reservation->price = $this->calculatePrice($reservation);
        if($reservation->price <= 0){
            throw new Exception('Error calculating price', 500);
        }
        if(!$reservation->save()){
            throw new Exception('Error saving reservation', 500);
        }
        return $reservation;


    }

    private function calculatePrice(Reservation $reservation): float
    {
        //with this someone can book a car for free check the added code
        $days = ceil(Carbon::parse($reservation->start_date)
            ->diffInDays(Carbon::parse($reservation->end_date)));

        //minimum 1 day to book
        // $days = max(1, $days);

        return $days * $reservation->car->price;
    }

    /**
     * @throws Exception
     */
    public function update(array $data, Reservation $reservation): Reservation
    {
        if(!$reservation->update($data))
        {
            throw new Exception('Error updating reservation', 500);
        }
        $reservation->update($data);
        $reservation->price = $this->calculatePrice($reservation);
        if($reservation->price <= 0){
            throw new Exception('Error calculating price', 500);
        }
        if(!$reservation->save()){
            throw new Exception('Error updating reservation', 500);
        }
        return $reservation;
    }

    /**
     * @throws Exception
     */
    public function destroy(Reservation $reservation): void
    {
        if($reservation->start_date < now()->addHours(48)) {
            throw new Exception('The reservation cannot be cancelled in less than 48 hours prior start', 403);
        }
        if(!$reservation->delete()){
            throw new Exception('Error deleting reservation', 500);
        }
    }
}
