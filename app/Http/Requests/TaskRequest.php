<?php

namespace App\Http\Requests;

/**
 * @OA\Schema(
 *      title="Task request",
 *      description="Task request body data",
 *      type="object",
 *      required={"title", "content"}
 * )
 * @OA\Property(property="title", type="string", example="Заголовок")
 * @OA\Property(property="content", type="string", example="Содержимое заявки/задачи. Текст большого объёма.")
 *
 * @property string title
 * @property string content
 */
class TaskRequest extends Request
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
            'title' => "required|string|min:3",
            'content' => "required|string|min:3",
        ];
    }
}
