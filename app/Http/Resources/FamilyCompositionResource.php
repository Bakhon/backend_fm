<?php

namespace App\Http\Resources;

use App\Models\FamilyComposition;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @OA\Schema(
 *     title="FamilyComposition",
 *     description="Family composition"
 * )
 * @OA\Property(property="id", type="integer")
 * @OA\Property(property="description", type="string")
 * @OA\Property(property="extension", type="string")
 * @OA\Property(property="template", type="string")
 * @OA\Property(property="required", type="boolean")
 *
 * @mixin FamilyComposition
 *
 */
class FamilyCompositionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'item_name' => $this->item_name,
            'description' => $this->description,
            'extension' => $this->extension,
            'template' => $this->template,
            'required' => (boolean)$this->required
        ];
    }
}
