<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
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
            'statut' => $this->status,
            'id' => $this->id,
            'slug' => $this->slug,
            'symbol' => $this->symbol,
            'code' => $this->code
        ];

        if ($this->statut == 1) {
            $arrayData["checked"] = "checked";
        }

        return $arrayData ;
    }
}
