<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="UserResource",
 *     description="User resource"
 * )
 * @OA\Property(property="user_hash", type="string")
 * @OA\Property(property="firstName", type="string")
 * @OA\Property(property="lastName", type="string")
 *
 * @property string $id
 * @property string $firstName
 * @property string $lastName
 */
class UserResource extends JsonResource
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
            'first_name' => $this->firstName ?? null,
            'last_name' => $this->lastName ?? null,
            'user_hash' => $this->id ?? null,
        ];
    }
}
