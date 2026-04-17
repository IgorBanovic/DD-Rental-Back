<?php

namespace App\Reports;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF;
use Validator;

class CarReport implements IReport
{
    public function getReportType(string $view, array $params = []): PDF
    {
        return PDF::loadView($view, $params);
    }

    public function getData(array $params = []): array
    {
        return Reservation::query()->join('cars', 'reservations.car_id', '=', 'cars.id')

            ->select('cars.id as car_id',
                'cars.brand',
                'cars.type',
                DB::raw('SUM(reservations.price) as total_revenue'),
                DB::raw('COUNT(reservations.id) as total_bookings'))

            ->whereBetween('reservations.start_date',
                [
                    Carbon::parse($params['start'])->startOfDay(),
                    Carbon::parse($params['end'])->endOfDay()])

            ->groupBy('cars.id',
                'cars.brand',
                'cars.type')

            ->orderByDesc('total_revenue')

            ->get()->toArray();
    }

    public function download(array $params = []): string
    {
        $data = $this->getData($params);

        $pdf = $this->getReportType('reports.car_performance', [
            'data' => $data,
            'period' => "{$params['start']} to {$params['end']}"
        ]);

        return $pdf->download('car-performance-report.pdf');
    }

    public array $parameters {
        get {
            return ['report', 'start', 'end'];
        }
    }
    public function validate(array $data): bool
    {
        $validator = Validator::make($data, [
            'start' => 'required|date',
            'end' => 'required|date'
        ]);

        if($validator->fails()) {
            return false;
        }
        else{
            return true;
        }
    }
}
