<?php

namespace App\Http\Resources\Api\mobile;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseWarehouseResource extends JsonResource
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
            'reference' => $this->reference,
            'id' => $this->id,
            'status' => $this->status

        ];
    }
}
