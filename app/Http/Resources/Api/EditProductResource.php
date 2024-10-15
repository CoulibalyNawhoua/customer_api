<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EditProductResource extends JsonResource
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
            'category_id' => $this->category_id,
            'subcategory_id' => $this->subcategory_id,
            'brand_id' => $this->brand_id,
            'image_url' => $this->image_url,
            'image' => asset('storage/'.$this->image_url),
            'unit_id' => $this->unit_id,
            'quantity' => $this->quantity,
            'tax_type' => $this->tax_type,
            'status' => $this->status,
            'stock_alert' => $this->stock_alert,
            'order_tax' => $this->order_tax,
            'sku' => $this->sku,
            'note' => $this->note,
            'supplier_id' => $this->supplier_id,
            'cost' => $this->cost,
        ];
    }
}
