<?php

namespace App\Http\Services;

use App\Models\Review;

class ReviewService
{
    public function store(array $data): Review
    {
        $review = new Review($data);
        $review->save();
        return $review;
    }

    public function update(array $data, Review $review): Review
    {
        $review->update($data);
        return $review;
    }

    public function destroy(Review $review): void
    {
        $review->delete();
    }
}
