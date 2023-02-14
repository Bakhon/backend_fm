<?php

namespace App\Http\Resources;

use App\Models\BICase;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class RegDataResource
 * @package App\Http\Resources
 *
 * @OA\Schema(
 *     title="RegData Resource",
 *     description="RegData Resource"
 * ),
 *
 * @OA\Property(property="id",type="integer")
 * @OA\Property(property="name",type="string")
 *
 * @mixin BICase
 */
class RegDataResource extends JsonResource
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
            'RegNumber' => $this->guid,
            'Version' => $this->version,
        ];
    }
}
