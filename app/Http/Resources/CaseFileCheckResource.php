<?php

namespace App\Http\Resources;

use App\Models\CaseVersion;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CaseFileCheckResource
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
 * @property int $is_load
 * @mixin CaseVersion
 */
class CaseFileCheckResource extends JsonResource
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
            'IsLoad' => $this->is_load,
            'Version' => $this->version,
        ];
    }
}
