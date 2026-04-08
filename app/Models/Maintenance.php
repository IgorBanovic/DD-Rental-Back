<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $appointment
 */
class Maintenance extends Model
{
    protected $fillable = [
        'appointment',
        'description',
        'car_id'
    ];

    use HasFactory;

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
