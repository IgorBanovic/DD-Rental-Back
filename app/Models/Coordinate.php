<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coordinate extends Model
{
    protected $fillable = [
        'latitude',
        'longitude',
        'car_id'
    ];

    use HasFactory;

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
