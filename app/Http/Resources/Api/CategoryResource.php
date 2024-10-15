<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $arrayData =  [
            'id' => $this->id,
            'name' => $this->name,
            'image_url' =>  $this->image_url,
            'comment' => $this->comment,
            'created_at' => Carbon::parse($this->created_at)->locale('fr')->isoFormat('LLLL'),
            'auteur' => $this->auteur->first_name.' '.$this->auteur->last_name,
            'slug' => $this->slug
        ];

        if ($this->image_url) {
            $arrayData["image_url"] =  asset('storage/'.$this->image_url);
        }
        else {
            $arrayData["image_url"] = '';
        }

        return $arrayData ;
    }
}
