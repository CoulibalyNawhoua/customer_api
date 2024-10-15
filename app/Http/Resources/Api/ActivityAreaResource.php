<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityAreaResource extends JsonResource
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
            'slug' => $this->slug,
            'id' => $this->id,

        ];

        if ($this->status == 1) {
            $arrayData["checked"] = "checked";
        }

        return $arrayData ;
    }
}
