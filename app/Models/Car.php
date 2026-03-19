<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'type',
        'brand',
        'model',
        'year',
        'price',
        'status',
        'description',
        'image'
    ];

}
