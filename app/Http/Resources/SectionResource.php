<?php

namespace App\Http\Resources;

use App\Models\Section;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class SectionResource
 * @package App\Http\Resources
 *
 * @OA\Schema(
 *     title="SectionResource",
 *     description="Section resource"
 * )
 * @OA\Property (property="id",type="integer")
 * @OA\Property (property="name",type="string")
 * @OA\Property (property="short_name",type="string")
 * @OA\Property (property="order",type="integer")
 * @OA\Property (property="parent_id",type="integer")
 * @OA\Property (property="creator_id",type="integer")
 *
 *
 * @mixin Section
 */
class SectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     *
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'short_name' => trim($this->short_name),
            'order' => trim($this->order),
            'parent_id' => $this->parent_id,
            'creator_id' => $this->creator_id,
        ];
    }
}
