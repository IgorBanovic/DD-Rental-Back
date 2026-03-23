<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    //
    public function index(): Collection
    {
        return Review::all();
    }

    public function store(Request $request): JsonResponse
    {
        $review = new Review($request->validate([
            'rate' => 'required|integer|min:1|max:10',
            'comment' => 'required|string|max:255',
            'car_id' => 'required|exists:cars,id',
            'user_id' => 'required|exists:users,id'
        ]));
        $review->save();
        return response()->json($review);
    }

    public function show(Review $review): JsonResponse
    {
        return response()->json($review);
    }

    public function update(Request $request, Review $review): JsonResponse
    {
        $review->update($request->validate([
            'rate' => 'sometimes|integer|min:1|max:10',
            'comment' => 'sometimes|string|max:255',
            'car_id' => 'sometimes|exists:cars,id',
            'user_id' => 'sometimes|exists:users,id'
        ]));

        return response()->json($review);
    }

    public function destroy(Review $review): JsonResponse
    {
        $review->delete();
        return response()->json(null, 204);
    }
}
