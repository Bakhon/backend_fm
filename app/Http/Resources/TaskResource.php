<?php

namespace App\Http\Resources;

use App\Models\Task;
use App\Services\KeyCloakService;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="TaskResource",
 *     description="Task resource"
 * )
 * @OA\Property(property="id", type="integer")
 * @OA\Property(property="status_id", type="integer")
 * @OA\Property(property="title", type="string")
 * @OA\Property(property="content", type="string")
 * @OA\Property(property="author", type="object", ref="#/components/schemas/UserResource")
 * @OA\Property(property="created_at", type="string")
 * @OA\Property(property="updated_at", type="string")
 * @OA\Property(property="deleted_at", type="string")
 * @OA\Property(property="executor", type="object", ref="#/components/schemas/UserResource")
 * @OA\Property(property="comment", type="string")
 *
 * @mixin Task
 */
class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param $request
     * @return array
     * @throws \App\Exceptions\ApiException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function toArray($request): array
    {
        $author = (new KeyCloakService())->getKeyCloakUser($this->creator_hash);
        $executor = (new KeyCloakService())->getKeyCloakUser($this->executor_hash);

        return [
            'id' => $this->id,
            'status_id' => $this->status_id,
            'title' => $this->title,
            'content' => $this->content,
            'author' => new UserResource($author),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'executor' => new UserResource($executor),
            'comment' => $this->comment,
        ];
    }
}
