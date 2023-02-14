<?php

namespace App\Http\Resources;

use App\Models\CaseVersion;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CaseVersionResource
 * @package App\Http\Resources
 *
 * @OA\Schema(
 *     title="CaseVersionSearchResource Resource",
 *     description="CaseFile resource"
 * ),
 *
 * @OA\Property(property="name",type="string")
 * @OA\Property(property="hash",type="string")
 * @OA\Property(property="type_id",type="integer")
 * @OA\Property(property="version",type="string")
 *
 * @mixin CaseVersion
 */
class CaseVersionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'hash' => $this->hash,
            'type_id' => $this->type_id,
            'version' => $this->version,
            'meta_data' => json_decode($this->meta_data),
            'file' => new FileResource($this->whenLoaded('file')),
        ];
    }
}
