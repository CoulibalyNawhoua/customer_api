<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'id' => $this->id,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'avatar_url' => asset('storage/'.$this->avatar),
            'add_date' => $this->add_date,
            'created_at' => $this->created_at,
            'auteur' => $this->auteur,
            'warehouse' => $this->company_name
        ];
    }
}
