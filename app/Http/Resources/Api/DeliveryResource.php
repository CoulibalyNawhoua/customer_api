<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data =  [
            'add_date' => Carbon::parse($this->add_date)->format('Y-m-d') ,
            'total_amount' => $this->total_amount,
            'discount_amount' => $this->discount_amount,
            'shipping_amount' => $this->shipping_amount,
            'warehouse_name' =>  $this->warehouse_name,
            'delivery_reference' => $this->delivery_reference,
            'order_reference' => $this->order_reference,
            'expected_delivery_date' => $this->expected_delivery_date,
            'id' => $this->id,
            'uuid' =>  $this->uuid,
            'status' =>  $this->status,
            'delivery_person' => $this->delivery_person

        ];

        return  $data;
    }
}
