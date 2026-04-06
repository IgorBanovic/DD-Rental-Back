<?php

namespace App\Http\Services;

use Illuminate\Support\Collection;
use App\Models\User;


class UserReportService
{
    public function getCustomerSatisfactionReport(): Collection
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
            });
    }

    public function calculateSentiment(?float $avgRate): string
    {
        if ($avgRate === null) return 'Neutral';
        if ($avgRate >= 8.5) return 'Very Happy';
        if ($avgRate >= 6.5) return 'Satisfied';
        if ($avgRate >= 4.5) return 'Neutral';
        return 'Unhappy';
    }

}
