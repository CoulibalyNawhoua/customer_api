<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryResource extends JsonResource
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
            'category' => $this->category->name,
            'auteur' => $this->auteur->name,
            'created_at' => Carbon::parse($this->created_at)->locale('fr')->isoFormat('LLLL'),
            'category_id' => $this->category_id,
            'comment' => $this->comment
        ];
    }
}
