<?php

namespace App\Http\Requests;

use App\Reference\TasksConstants;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *      title="Task update request",
 *      description="Task request body data",
 *      type="object",
 *      required={"title", "content"}
 * )
 * @OA\Property(property="title", type="string", example="Заголовок")
 * @OA\Property(property="content", type="string", example="Содержимое заявки/задачи. Текст большого объёма.")
 *
 * @property int $status_id
 * @property string $comment
 * @property string $executor_hash
 */
class TaskUpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status_id' => "nullable|integer|" . Rule::in(TasksConstants::TASK_STATUS_IDS),
            'comment' => "nullable|string|min:3",
            'executor_hash' => "nullable|string",
        ];
    }
}
