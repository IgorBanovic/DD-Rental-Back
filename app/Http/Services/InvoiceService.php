<?php

namespace App\Http\Services;

use App\Models\Reservation;
use Barryvdh\DomPDF\PDF;
class InvoiceService
{
    public function generatePDF(Reservation $reservation): PDF
    {
        $reservation->load(['user', 'car']);

        $data = [
            'reservation' => $reservation,
            'invoice_no' => 'INV-' . str_pad($reservation->id, 5, '0', STR_PAD_LEFT),
            'issue_date' => now()->format('Y-m-d'),
        ];

        return PDF::loadView('invoice.invoice', $data);
    }
}
