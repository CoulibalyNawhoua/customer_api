<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'purchase_date' => Carbon::parse($this->purchase_date)->format('Y-m-d') ,
            'total_amount' => $this->total_amount,
            'paid_amount' => $this->paid_amount,
            'due_amount' => $this->due_amount,
            'subtotal_amount' => $this->subtotal_amount,
            'status' => $this->status,
            'warehouse_name' => $this->warehouse_name,
            'supplier' =>  $this->supplier,
            'reference' => $this->reference,
            'expected_delivery_date' => $this->expected_delivery_date,
            'id' => $this->id,

        ];
    }
}
