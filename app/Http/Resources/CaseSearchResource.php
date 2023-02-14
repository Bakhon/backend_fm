<?php

namespace App\Http\Resources;

use App\Models\BICase;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CaseSearchResource
 * @package App\Http\Resources
 *
 * @OA\Schema(
 *     title="CaseSearch Resource",
 *     description="CaseSearch resource"
 * )
 *
 * @OA\Property(property="id", type="integer")
 * @OA\Property(property="title", type="string")
 * @OA\Property(property="created_at", type="string")
 * @OA\Property(property="updated_at", type="string")
 * @OA\Property(property="deleted_at", type="string")
 * @OA\Property(property="version", type="string")
 * @OA\Property(property="hash", type="string")
 * @OA\Property(property="file_size", type="string")
 * @OA\Property(property="category_revit", type="string")
 * @OA\Property(property="family_placement", type="string")
 * @OA\Property(property="shared_parameters", type="string")
 * @OA\Property(property="type_collection", type="array", @OA\Items(type="string"))
 * @OA\Property(property="family_template", type="string")
 * @OA\Property(property="system_parameters", type="string")
 * @OA\Property(property="count_subfamily", type="string")
 * @OA\Property(property="count_connector", type="string")
 * @OA\Property(property="author", type="object", ref="#/components/schemas/UserResource")
 * @OA\Property(property="category", type="object", ref="#/components/schemas/CategoryResource")
 * @OA\Property(property="section", type="object", ref="#/components/schemas/SectionResource")
 * @OA\Property(property="Files", type="array",
 *     @OA\Items(type="object", format="query", ref="#/components/schemas/CaseFileRequest"),
 * )
 *
 * @mixin BICase
 */
class CaseSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'version' => $this->version,
            'hash' => $this->guid,
            'file_size' => $this->file_size,
            'category_revit' => $this->category_revit,
            'family_placement' => $this->family_placement,
            'shared_parameters' => $this->shared_parameters,
            'type_collection' => $this->type_collection,
            'family_template' => $this->family_template,
            'system_parameters' => $this->system_parameters,
            'count_subfamily' => $this->count_subfamily,
            'count_connector' => $this->count_connector,
            'author' => $this->author,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'section' => new SectionResource($this->whenLoaded('section')),
            'files' => CaseVersionSearchResource::collection($this->caseVersions),
            'all_files' => CaseVersionSearchResource::collection($this->caseAllVersions),
        ];
    }
}
