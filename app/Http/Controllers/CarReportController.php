<?php

namespace App\Http\Controllers;

use App\Http\Services\CarReportService;
use Exception;
use App\Http\Requests\Report\ReportRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class CarReportController extends Controller
{
    public function carPerformance(ReportRequest $request, CarReportService $reportService)
    {
        try {
            $reportData = $reportService->getCarPerformanceReport(
                $request->validated('start_date'),
                $request->validated('end_date')
            );

            return response()->json([
                'report_name' => 'Car Performance Report',
                'period' => "{$request->validated('start_date')} to {$request->validated('end_date')}",
                'data' => $reportData
            ]);

        } catch (Exception) {
            return response()->json(['error' => 'Failed to generate report'], 500);
        }
    }

    public function downloadCarPerformancePdf(ReportRequest $request, CarReportService $reportService)
    {
        try {
            $reportData = $reportService->getCarPerformanceReport(
                $request->validated('start_date'),
                $request->validated('end_date')
            );

            $pdf = Pdf::loadView('reports.car_performance', [
                'data' => $reportData,
                'period' => "{$request->validated('start_date')} to {$request->validated('end_date')}"
            ]);

            return $pdf->download('car-performance-report.pdf');
        } catch (Exception) {
            return response()->json(['error' => 'Failed to download report: '], 500);
        }
    }
}
