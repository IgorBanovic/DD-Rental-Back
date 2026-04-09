<?php

namespace App\Reports;

use Barryvdh\DomPDF\PDF;

class Invoice implements IReport
{
    public function getReportType(string $view, array $params = []): PDF
    {
        return PDF::loadView($view, $params);
    }

    public function getData(array $params = []): array
    {
        $reservation = $params['reservation'];
        $reservation->load(['user', 'car']);

        return [
            'reservation' => $reservation,
            'invoice_no' => 'INV-' . str_pad($reservation->id, 5, '0', STR_PAD_LEFT),
            'issue_date' => now()->format('Y-m-d'),
        ];
    }

    public function download(array $params = []): string
    {
        $reservation = $params['reservation'];
        $data = $this->getData($params['reservation']);
        $pdf = $this->getReportType('invoice.invoice', $data);
        return $pdf->download('invoice-' . $reservation->id . '.pdf');
    }
}
