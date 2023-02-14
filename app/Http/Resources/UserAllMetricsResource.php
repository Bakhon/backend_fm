<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\KeyCloakService;

class UserAllMetricsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $author = (new KeyCloakService())->getKeyCloakUser($this->user_hash);

        return [
            'file_id' => $this->file_id,
            'original_name' => $this->original_name,
            'version' => $this->version,
            'name' => $this->name,
            'fullname' => $this->full_name,
            'author' => $author ? $author->firstName . ' ' . $author->lastName : '',
            'email' => $author->email,
            'date_download' => $this->date_download,
            'count' => $this->count,
            ];
    }
}
