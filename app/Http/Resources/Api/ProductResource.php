<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'designation' => $this->designation,
            'price' => $this->price,
            'category' => $this->category,
            'subcategory' => $this->subcategory,
            'brand' => $this->brand,
            'auteur' => $this->auteur,
            'image_url' => asset('storage/'.$this->image_url),
            'unit' => $this->unit,
            'created_at' => Carbon::parse($this->add_date)->format('Y-m-d'),
            'sku' => $this->sku,
            'quantity' => $this->quantity
        ];
    }
}
