<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * Class CategoryResource
 * @package App\Http\Resources
 *
 * @OA\Schema(
 *     title="CategoryResource",
 *     description="Category resource"
 * )
 * @OA\Property (property="id",type="integer")
 * @OA\Property (property="full_name",type="string")
 * @OA\Property (property="name",type="string")
 * @OA\Property (property="system",type="string")
 * @OA\Property (property="number",type="integer")
 * @OA\Property (property="creator_id",type="integer")
 *
 * @mixin Category
 */
class CategoryResource extends JsonResource
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
            'full_name' => $this->full_name,
            'name' => $this->name,
            'system' => $this->system,
            'number' => $this->number,
            'creator_id' => $this->creator_id,
            'sections' => SectionResource::collection($this->whenLoaded('sections'))
        ];
    }
}
