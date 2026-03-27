<?php

namespace App\Http\Controllers\Car;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserReservationsController
{
    public function index(User $user): JsonResponse
    {
        return response()->json($user->reservations);
    }
}
