<?php

namespace App\Http\Resources;

use App\Models\ReportFamily;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ReportFamilyResource
 * @package App\Http\Resources
 *
 * @OA\Schema(
 *     title="ReportFamily Resource"
 * ),
 * @OA\Property(property="family_name", type="string")
 * @OA\Property(property="guid", type="string")
 * @OA\Property(property="version", type="integer")
 * @OA\Property(property="current_version", type="integer")
 * @OA\Property(property="report_id", type="integer")
 * @OA\Property(property="status", type="integer")
 * @OA\Property(property="url", type="string")
 *
 * @mixin ReportFamily
 */
class ReportFamilyResource extends JsonResource
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
            'family_id' => $this->family_id,
            'family_name' => $this->name,
            'guid' => $this->guid,
            'version' => $this->version,
            'current_version' => $this->current_version,
            'report_id' => $this->report_id,
            'status' => $this->status_id,
            'url' => $this->url,
        ];
    }
}
