<?php

namespace App\Http\Resources;

use App\Models\Report;
use App\Reference\Constants;
use App\Services\KeyCloakService;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ReportResource
 * @package App\Http\Resources
 *
 * @OA\Schema(
 *     title="Report Resource"
 * ),
 * @OA\Property(property="id", type="integer")
 * @OA\Property(property="project", type="string")
 * @OA\Property(property="report", type="string")
 * @OA\Property(property="families_count", type="integer")
 * @OA\Property(property="family_errors", type="integer")
 * @OA\Property(property="families", type="array",
 *     @OA\Items(type="object", format="query", ref="#/components/schemas/ReportFamilyResource"),
 * ),
 *
 * @mixin Report
 */
class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     * @throws \Exception
     */
    public function toArray($request)
    {
        $author = (new KeyCloakService())->getKeyCloakUser($this->user_hash);
        $date = $this->created_at;
        $created_at = $date->addHours(6);
        
        return [
            'id' => $this->id,
            'report' => $this->guid,
            'project' => $this->name,
            'author' => $author->firstName . ' ' . $author->lastName,
            'families_count' => $this->families_count,
            'family_errors' => $this->family_errors,
            'created_at' => $created_at->format(Constants::DATE_TIME_FORMAT), 
            'url' => $this->url,
            'families' => ReportFamilyResource::collection($this->whenLoaded('reportFamilies')),
        ];
    }
}
