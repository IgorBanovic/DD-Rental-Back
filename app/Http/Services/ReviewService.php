<?php

namespace App\Http\Services;

use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Http\Resources\ReviewCollection;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\JsonResponse;

class ReviewService
{
    public function store(array $data): Review
    {
        $review = new Review($data);
        $review->save();
        return $review;
    }

    public function update(array $data, Review $review)
    {
        $review->update($data);
        return $review;
    }

    public function destroy(Review $review): void
    {
        $review->delete();
    }
}
