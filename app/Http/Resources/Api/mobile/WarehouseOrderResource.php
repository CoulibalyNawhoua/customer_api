<?php

namespace App\Http\Resources\Api\mobile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'add_date' => $this->add_date,
            'reference' => $this->reference,
            'total_amount' => $this->total_amount,
            'id' => $this->id,
            'status' => $this->status,
            'shipping_amount' => $this->shipping_amount,
            'subtotal_amount' => $this->subtotal_amount,
            'comment' => $this->comment,
        ];
    }
}
