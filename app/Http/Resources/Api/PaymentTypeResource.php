<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $arrayData = [
            'name' => $this->name,
            'status' => $this->status,
            'id' => $this->id,
            'slug' => $this->slug,
        ];

        if ($this->status == 1) {
            $arrayData["checked"] = "checked";
        }

        return $arrayData ;
    }
}
