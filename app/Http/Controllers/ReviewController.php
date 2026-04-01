<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Http\Services\ReviewService;
use App\Models\Review;
use Exception;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request, ReviewService $reviewService)
    {
        try {
            $review = $reviewService->store($request->validated());
            return new ReviewResource($review);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function show(Review $review)
    {
        $review = Review::with(['user', 'car'])->findOrFail($review->id);
        return new ReviewResource($review);
    }
    public function update(Review $review, UpdateReviewRequest $request, ReviewService $reviewService)
    {
        try {
            $review = $reviewService->update($request->validated(), $review);
            return new ReviewResource($review);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
    public function destroy(Review $review, ReviewService $reviewService)
    {
        $this->authorize('delete', $review);
       try {
            $reviewService->destroy($review);
            return response()->json('Review successfully deleted');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

}
