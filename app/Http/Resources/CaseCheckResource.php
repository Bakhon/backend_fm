<?php

namespace App\Http\Resources;

use App\Models\BICase;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CaseCheckResource
 * @package App\Http\Resources
 *
 * @OA\Schema(
 *     title="Case Resource",
 *     description="Case resource"
 * ),
 *
 * @OA\Property(property="id",type="integer")
 * @OA\Property(property="name",type="string")
 * @OA\Property(property="guid",type="string")
 * @OA\Property(property="creator_id",type="integer")
 * @OA\Property(property="category_id",type="integer")
 * @OA\Property(property="status",type="integer")
 *
 * @mixin BICase
 */
class CaseCheckResource extends JsonResource
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
            'CaseName' => $this->name,
            'CaseHashAfter' => trim($this->key),
            'CaseHashBefore' => trim($this->key),
            'RegData' => new RegDataResource($this),
            'CategoryID' => $this->category_id,
            'SectionID' => $this->section_id,
            'DeletedAt' => $this->deleted_at,
            'Files' => $this->files
        ];
    }
}
