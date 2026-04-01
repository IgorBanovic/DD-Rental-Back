<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewCollection;
use App\Http\Services\ReviewService;
use App\Models\Car;

class CarReviewsController extends Controller
{
    public function index(Car $car, ReviewService $reviewService)
    {
        $reviews = $reviewService->carReviews($car);
        return new ReviewCollection($reviews);
    }

}
