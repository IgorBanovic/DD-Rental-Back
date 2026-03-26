<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $rate
 * @property mixed $comment
 * @property mixed $user_id
 * @property mixed $car_id
 */
class ReviewResource extends JsonResource
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
            'rate' => $this->rate,
            'comment' => $this->comment,
            'user_id' => $this->user_id,
            'car_id' => $this->car_id
        ];
    }
}
