<?php

namespace App\Http\Requests;


/**
 * @OA\Schema(
 *      title="Case Init request",
 *      description="Case init request body data",
 *      type="object",
 *      required={"name, category_id, section_id"}
 * )
 * @OA\Property(property="name", type="string", example="(Dr)_ Door78_Дверь Двустворчатая_Внутренняя_ГОСТ 31173"),
 * @OA\Property(property="category_id", type="integer", example=1),
 * @OA\Property(property="section_id", type="integer", example=1),
 *
 * @property string $name
 * @property int $category_id
 * @property int $section_id
 */
class CaseInitRequest extends Request
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
            'name' => "required|string",
            'category_id' => 'required||integer|exists:categories,id',
            'section_id' => 'required||integer|exists:sections,id',
        ];
    }
}
