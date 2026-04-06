<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    protected $fillable = [
        'type',
        'brand',
        'year',
        'price',
        'status',
        'description',
        'image',
        'latitude',
        'longitude',
    ];

    use HasFactory;

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function coordinates(): HasMany
    {
        return $this->hasMany(Coordinate::class);
    }
}
