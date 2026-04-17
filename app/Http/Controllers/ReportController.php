<?php

namespace App\Http\Controllers;

use App\Reports\CarReport;
use App\Reports\Invoice;
use App\Reports\IReport;
use App\Reports\UserReport;
use Illuminate\Http\Request;
use Validator;

class ReportController extends Controller
{
    private array $mapping = [
        'invoice' => Invoice::class,
        'user' => UserReport::class,
        'car' => CarReport::class
    ];

    public function create(Request $request)
    {
        /** @var IReport $report */
        $validator = Validator::make($request->all(), [
            'report' => 'required|string|in:car,invoice,user'
        ]);
        if (!$validator->fails()) {
            $report = new $this->mapping[$request->report]();
            if (!$report->validate($request->all())) {
                return response()->json(['Validation error', 403]);
            }
            return $report->download($request->all());
        }
        else{
            return response()->json(['Validation error', 403]);
        }
    }
}
