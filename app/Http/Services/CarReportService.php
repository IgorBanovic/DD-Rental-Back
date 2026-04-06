<?php

namespace App\Http\Services;

use App\Models\Reservation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class CarReportService
{
    public function getCarPerformanceReport(string $start, string $end): Collection
    {
        return Reservation::query()->join('cars', 'reservations.car_id', '=', 'cars.id')

            ->select('cars.id as car_id',
                  'cars.brand',
                             'cars.type',
                              DB::raw('SUM(reservations.price) as total_revenue'),
                              DB::raw('COUNT(reservations.id) as total_bookings'))

            ->whereBetween('reservations.start_date',
                                  [Carbon::parse($start)->startOfDay(),Carbon::parse($end)->endOfDay()])

            ->groupBy('cars.id',
                               'cars.brand',
                               'cars.type')

            ->orderByDesc('total_revenue')

            ->get();
    }
}
