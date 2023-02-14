<?php

namespace App\Http\Resources;

use App\Models\SectionCategory;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * Class SectionCategoryResource
 * @package App\Http\Resources
 *
 * @OA\Schema(
 *     title="SectionCategoryResource",
 *     description="SectionCategory resource"
 * )
 * @OA\Property (property="id",type="integer")
 *
 * @mixin SectionCategory
 */
class SectionCategoryResource extends JsonResource
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
            'id' => $this->id,
            'section' => new SectionResource($this->whenLoaded('section')),
            'category' => new CategoryResource($this->whenLoaded('category')),
        ];
    }
}
