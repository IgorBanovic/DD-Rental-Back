<?php

namespace App\Reports;

use App\Models\User;
use Barryvdh\DomPDF\PDF;

class UserReport implements IReport
{
    public function getReportType(string $view, array $params = []): PDF
    {
        return PDF::loadView($view, $params);
    }

    public function getData(?array $params = []): array
    {
        return User::query()
            ->where('is_admin', false)
            ->withCount('reviews')
            ->withAvg('reviews', 'rate')
            ->with(['reviews' => function($query) {
                $query->latest()->limit(1);
            }])

            ->get()->map(function ($user) {
                return [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'total_reviews' => $user->reviews_count,
                    'average_rating' => round($user->reviews_avg_rate, 1) ?: 0,
                    'last_feedback' => $user->reviews->first()?->comment ?? 'No feedback yet',
                    'sentiment' => $this->calculateSentiment($user->reviews_avg_rate),
                ];
            })->toArray();
    }

    private function calculateSentiment(?float $avgRate): string
    {
        if ($avgRate === null) return 'Neutral';
        if ($avgRate >= 8.5) return 'Very Happy';
        if ($avgRate >= 6.5) return 'Satisfied';
        if ($avgRate >= 4.5) return 'Neutral';
        return 'Unhappy';
    }

    public function download(?array $params = []): string
    {
        $reportData = $this->getData();

        $pdf = $this->getReportType('reports.customer_satisfaction', [
            'data' => $reportData,
            'generated_at' => now()->toDateTimeString()
        ]);

        return $pdf->download('customer-satisfaction-report.pdf');
    }

    public array $parameters {
        get {
            return null;
        }
    }

    public function validate(array $data): bool
    {
        return true;
    }
}
