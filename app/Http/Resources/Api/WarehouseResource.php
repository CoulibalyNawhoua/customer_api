<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'warehouse_logo'=> $this->warehouse_logo,
            'warehouse_address' => $this->warehouse_address,
            'warehouse_email' => $this->warehouse_email,
            'num_Identification_fiscale' => $this->num_Identification_fiscale,
            'warehouse_name' => $this->warehouse_name,
            'activity_id' => $this->activity_id,
        ];
    }
}
