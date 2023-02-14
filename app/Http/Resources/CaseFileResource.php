<?php

namespace App\Http\Resources;

use App\Models\CaseVersion;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CaseFile
 * @package App\Http\Resources
 *
 * @OA\Schema(
 *     title="CaseFile Resource",
 *     description="CaseFile resource"
 * ),
 *
 * @OA\Property(property="id",type="integer")
 * @OA\Property(property="name",type="string")
 * @OA\Property(property="guid",type="string")
 * @OA\Property(property="creator_id",type="integer")
 * @OA\Property(property="category_id",type="integer")
 * @OA\Property(property="status",type="integer")
 *
 * @mixin CaseVersion
 */
class CaseFileResource extends JsonResource
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
            'Name' => $this->name,
            'Hash' => $this->hash,
            'CaseItemTypeId' => $this->type_id,
            'IsLoad' => $this->file ? true : false,
            'Version' => $this->version,
            'MetaData' => json_decode($this->meta_data),
        ];
    }
}
