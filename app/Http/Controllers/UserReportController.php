<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Services\UserReportService;
use Barryvdh\DomPDF\Facade\Pdf;

class UserReportController extends Controller
{
    public function customerSatisfaction(UserReportService $reportService)
    {
        try {
            $report = $reportService->getCustomerSatisfactionReport();

            return response()->json([
                'report_type' => 'Customer Satisfaction & Sentiment',
                'generated_at' => now()->toDateTimeString(),
                'data' => $report
            ]);
        } catch (Exception) {
            return response()->json(['error' => 'Failed to generate satisfaction report'], 500);
        }
    }

    public function downloadCustomerSatisfactionPdf(UserReportService $reportService)
    {
        try {
            $reportData = $reportService->getCustomerSatisfactionReport();

            $pdf = Pdf::loadView('reports.customer_satisfaction', [
                'data' => $reportData,
                'generated_at' => now()->toDateTimeString()
            ]);

            return $pdf->download('customer-satisfaction-report.pdf');
        } catch (Exception) {
            return response()->json(['error' => 'Failed to download report: '] , 500);
        }
    }

}
