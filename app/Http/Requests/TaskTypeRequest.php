<?php

namespace App\Http\Requests;

use App\Models\TaskType;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class TaskTypeRequest
 * @package App\Http\Requests
 *
 * @OA\Schema(
 *      title="Task Type request",
 *      description="Task Type request body data",
 *      type="object",
 *      required={"key","title", "description"}
 * )
 * @OA\Property (property="key",type="string",example="change_request"),
 * @OA\Property (property="title",type="string",example="Заявна на изменение"),
 * @OA\Property (property="description",type="string",example="Используется для запроса на внесение ихменений в каталог"),
 *
 * @mixin TaskType
 *
 */
class TaskTypeRequest extends Request
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
     * Get the validation rules that apply to the  request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'key' => "required|string",
            'title' => "required|string",
            'description' => "nullable|string",
        ];
    }
}
