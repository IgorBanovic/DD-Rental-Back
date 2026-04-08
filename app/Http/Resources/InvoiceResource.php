<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $price
 * @property mixed $id
 */
class InvoiceResource extends JsonResource
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
            'invoice_number' => 'INV-' . str_pad($this->id, 5, '0', STR_PAD_LEFT),
            'total_price' => $this->price,
            'download_url' => url("/api/reservations/{$this->id}/invoice/download"),
        ];
    }
}
