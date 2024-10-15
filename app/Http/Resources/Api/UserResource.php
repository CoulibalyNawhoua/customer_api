<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'role' => $this->getRoleNames()[0]  ?? '',
            'status' => $this->active,
            'full_name' => $this->full_name,
            'slug' => 'user'.'-'.$this->id,
        ];


        if ($this->active == 1) {
            $arrayData["checked"] = "checked";
        }

        return $arrayData;
    }
}
