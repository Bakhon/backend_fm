<?php

namespace App\Http\Resources;

use App\Services\KeyCloakService;
use App\Models\UserFiles;
use Illuminate\Http\Resources\Json\JsonResource;

class UserFilesResource extends JsonResource
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
            'id' => $this->id,
            'file_id' => $this->file_id,
            'date_download' => $this->date_download,
            'author' => $author->firstName . ' ' . $author->lastName,
        ];
    }
}
