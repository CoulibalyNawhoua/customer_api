<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'comment' => $this->comment,
            'created_date' => Carbon::parse($this->created_at)->locale('fr')->isoFormat('LLLL'),
            'auteur' => $this->auteur->first_name.' '.$this->auteur->last_name
        ];
    }
}
