<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationCollection;
use App\Models\User;

class UserReservationsController
{
    public function index(User $user)
    {
        return new ReservationCollection($user->reservations);
    }
}
