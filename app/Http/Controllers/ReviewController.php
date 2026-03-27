<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Http\Services\ReviewService;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request, ReviewService $reviewService)
    {
        $review = $reviewService->store($request->all());
        return new ReviewResource($review);
    }

    public function show(Review $review)
    {
        return new ReviewResource($review);
    }
    public function update(Review $review, UpdateReviewRequest $request, ReviewService $reviewService)
    {
        $review = $reviewService->update($request->all(), $review);
        return new ReviewResource($review);
    }
    public function destroy(Review $review, ReviewService $reviewService)
    {
        $this->authorize('delete', $review);
        $reviewService->destroy($review);
        return response()->json('Review successfully deleted');
    }

}
