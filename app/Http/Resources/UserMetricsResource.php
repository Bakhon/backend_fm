<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\KeyCloakService;
use App\Reference\Constants;
use Carbon\Carbon;

class UserMetricsResource extends JsonResource
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
        $firstname = '';
        if(isset($author->firstName)) {
            $firstname = $author->firstName;
        }
        $lastname = '';
        if(isset($author->lastName)) {
            $lastname = $author->lastName;
        }
        $title = '';
        if(isset($author->attributes->title)) {
            $title = $author->attributes->title[0];
        }
        $company = '';
        if(isset($author->attributes->company)) {
            $company = $author->attributes->company[0];
        }
        $created_at = Carbon::parse($this->date_download)->addHours(6);

        return [
            'file_id' => $this->file_id,
            'original_name' => $this->original_name,
            'name' => $this->name,
            'fullname' => $this->full_name,
            'author' => $firstname . ' ' . $lastname,
            'title' => $title,
            'company' => $company,
            'email' => $author->email,
            'date_download' => $created_at->format(Constants::DATE_TIME_FORMAT),
            'count' => $this->count,
            ];
    }
}
