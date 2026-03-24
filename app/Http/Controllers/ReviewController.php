<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Review::all());
    }

    public function store(StoreReviewRequest $request): JsonResponse
    {
        $review = $request;
        $review->save();
        return response()->json($review, 201);
    }

    public function show(Review $review): JsonResponse
    {
        return response()->json($review);
    }

    public function update(UpdateReviewRequest $request, Review $review): JsonResponse
    {
        $review = $request;
        $review->save();
        return response()->json($review);
    }

    public function destroy(Review $review): JsonResponse
    {
        $review->delete();
        return response()->json(['message' => 'Review deleted successfully'], 204);
    }
}
