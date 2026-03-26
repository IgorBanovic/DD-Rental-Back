<?php

namespace App\Http\Controllers\Car;

use App\Models\Car;

class ReviewController
{
    public function index(Car $car)
    {
        return $car->reviews;
    }
}
