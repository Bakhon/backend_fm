<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MetricsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) : array
    {
        return [
            'id' => $this->id,
            'original_name' => $this->original_name,
            'version' => $this->version,
            'name_family' => $this->name,
            'category_name' => $this->full_name,
            'count' => $this->count,
        ];
    }
}
