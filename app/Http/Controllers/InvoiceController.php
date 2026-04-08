<?php

namespace App\Http\Controllers;


use App\Models\Reservation;
use App\Http\Services\InvoiceService;
use App\Http\Resources\InvoiceResource;


class InvoiceController extends Controller
{
    public function show(Reservation $reservation)
    {
        return new InvoiceResource($reservation);
    }

    public function download(Reservation $reservation, InvoiceService $invoiceService)
    {
        $pdf = $invoiceService->generatePDF($reservation);
        return $pdf->download("invoice-{$reservation->id}.pdf");
    }
}
