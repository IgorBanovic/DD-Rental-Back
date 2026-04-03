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
 * @property mixed $status
 * @property mixed $description
 * @property mixed $image
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
        $resource = [
            'id' => $this->id,
            'type' => $this->type,
            'brand' => $this->brand,
            'year' => $this->year,
            'price' => $this->price,
            'description' => $this->description,
            'image' => $this->image
        ];

        if(auth()->user()->is_admin)
            $resource['status'] = $this->status;

        return $resource;
    }
}
