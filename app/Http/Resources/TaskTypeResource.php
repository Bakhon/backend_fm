<?php

namespace App\Http\Resources;

use App\Models\TaskType;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class TaskTypeResource
 * @package App\Http\Resources
 *
 * @OA\Schema(
 *     title="TaskTypeResource",
 *     description="Task Type resource"
 * )
 * @OA\Property (property="key",type="string",example="change_request"),
 * @OA\Property (property="title",type="string",example="Заявна на изменение"),
 * @OA\Property (property="description",type="string",example="Используется для запроса на внесение ихменений в каталог"),
 *
 * @mixin TaskType
 */
class TaskTypeResource extends JsonResource
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
            'key' => $this->key,
            'title' => $this->title,
            'description' => $this->description
        ];
    }
}
