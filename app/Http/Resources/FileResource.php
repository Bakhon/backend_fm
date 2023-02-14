<?php

namespace App\Http\Resources;

use App\Models\File;
use App\Reference\Constants;
use App\Services\KeyCloakService;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class FileResource
 * @package App\Http\Resources
 *
 * @OA\Schema(
 *     title="File Resource",
 *     description="File Resource"
 * ),
 *
 * @OA\Property(property="name", type="string")
 * @OA\Property(property="extension", type="string")
 * @OA\Property(property="original_name", type="string")
 * @OA\Property(property="mime_type", type="string")
 * @OA\Property(property="path", type="string")
 *
 * @mixin File
 */
class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $author = (new KeyCloakService())->getKeyCloakUser($this->user_hash);

        return [
            'extension' => $this->extension,
            'original_name' => $this->original_name,
            'mime_type' => $this->mime_type,
            'hash' => $this->hash,
            'created_at' => $this->created_at->format(Constants::DATE_TIME_FORMAT),
            'author' => new UserResource($author)
        ];
    }
}
