<?php

namespace App\Http\Controllers\Car;

use App\Http\Resources\ReviewCollection;
use App\Models\Car;

class ReviewController
{
    public function index(Car $car)
    {
        return new ReviewCollection($car->reviews);
    }

}
