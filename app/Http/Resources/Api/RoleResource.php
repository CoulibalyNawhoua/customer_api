<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $arrayData = [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->name.'-'.$this->id
        ];

        if ($this->status == 0) {
            $arrayData["checked"] = "checked";
        }

        return $arrayData ;
    }
}
