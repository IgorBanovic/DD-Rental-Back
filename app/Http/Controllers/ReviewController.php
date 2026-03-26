<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Http\Resources\ReviewCollection;
use App\Http\Resources\ReviewResource;
use App\Http\Services\ReviewService;
use App\Models\Review;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    public function index()
    {
        return new ReviewCollection(Review::all());
    }
    public function store(StoreReviewRequest $request, ReviewService $reviewService)
    {
        $review = $reviewService->store((array)$request);
        return new ReviewResource($review);
    }
    public function show(Review $review)
    {
        return new ReviewResource($review);
    }
    public function update(Review $review, UpdateReviewRequest $request, ReviewService $reviewService)
    {
        $review = $reviewService->update((array)$request, $review);
        return new ReviewResource($review);
    }
    public function destroy(Review $review, ReviewService $reviewService)
    {
        $reviewService->destroy($review);
        return response()->json('Review successfully deleted');
    }

}
