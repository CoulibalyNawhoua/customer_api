<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'order_date' => $this->order_date,
            'reference' => $this->reference,
            'total_amount' => $this->total_amount,
            'paid_amount' => $this->paid_amount,
            'due_amount' => $this->due_amount,
            'payment_status' => $this->payment_status,
            'status' => $this->status,
            'auteur' => $this->auteur,
            'type_user' => $this->type_user,
            'warehouse_name' =>  $this->warehouse_name,
            'subtotal_amount' => $this->subtotal_amount,
            'shipping_amount' => $this->shipping_amount,
            'process_status' => $this->process_status,
            'uuid' => $this->uuid,
            'id' => $this->id,
        ];;
    }
}
