<?php

namespace App\Http\Resources\Api\mobile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductWarehouseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'designation' => $this->designation,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'image_url' => asset('storage/'.$this->image_url),
            'product_id' => $this->product_id,
            'product_warehouse_id' => $this->product_warehouse_id
        ];
    }
}
