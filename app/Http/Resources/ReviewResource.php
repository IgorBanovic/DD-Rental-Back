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
 * @property mixed $user
 * @property mixed $car
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
            'email' => $this->comment,
            'user' => [
                'id' => $this->user_id,
                'name' => $this->user->name,
            ],
            'car_id' => $this->car_id
        ];
    }
}
