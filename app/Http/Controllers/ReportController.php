<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reservation\StoreReservationRequest;
use App\Models\Reservation;
use App\Reports\CarReport;
use App\Reports\Invoice;
use App\Reports\UserReport;
use Validator;

class ReportController extends Controller
{
    public function carReport(string $start, string $end)
    {
        $validator = Validator::make(
            compact('start', 'end'),
            [
                'start' => 'required|date',
                'end' => 'required|date|after:start',
            ]
        );
        $validated = $validator->validate();
        $report = new CarReport();
        return $report->download(['start' => $validated['start'], 'end' => $validated['end']]);
    }

    public function customerReport()
    {
        $report = new UserReport();
        return $report->download();
    }

    public function invoice(Reservation $reservation)
    {
        $report = new Invoice();
        return $report->download(['reservation' => $reservation]);
    }
}
