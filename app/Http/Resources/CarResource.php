<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $type
 * @property mixed $brand
 * @property mixed $year
 * @property mixed $price
 * @property mixed $description
 * @property mixed $image
 * @property mixed $status
 */
class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'brand' => $this->brand,
            'year' => $this->year,
            'status' => $this->status->when(auth()->check() && auth()->user()->is_admin),
            'price' => $this->price,
            'description' => $this->description,
            'image' => $this->image,
        ];
    }
}
