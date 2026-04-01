<?php

namespace App\Http\Services;

use App\Models\Car;
use App\Models\Review;
use Exception;
use Illuminate\Support\Collection;

class ReviewService
{
    /**
     * @throws Exception
     */
    public function store(array $data): Review
    {
        $review = new Review($data);
        if(!$review->save()){
            throw new Exception("Error saving review", 500);
        }
        return $review;
    }

    /**
     * @throws Exception
     */
    public function update(array $data, Review $review): Review
    {
        if(!$review->update($data)){
            throw new Exception('Error updating review', 500);
        }
        return $review;
    }

    /**
     * @throws Exception
     */
    public function destroy(Review $review): void
    {
        if(!$review->delete()){
            throw new Exception('Error deleting review', 500);
        }
    }

    public function carReviews(Car $car): Collection
    {
        return Review::with(['user', 'car'])->where('car_id', $car->id)->get();
    }
}
