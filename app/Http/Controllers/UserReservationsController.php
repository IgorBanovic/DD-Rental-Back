<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationCollection;
use App\Http\Services\ReservationService;
use App\Models\User;

class UserReservationsController extends Controller
{
    public function index(User $user, ReservationService $reservationService)
    {
        $reservations = $reservationService->userReservations($user);
        return new ReservationCollection($reservations);
    }
}
