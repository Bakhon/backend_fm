<?php

namespace App\Http\Requests;

use Exception;

/**
 * @OA\Schema(
 *      title="Case update request",
 *      description="Case update request body data",
 *      type="object",
 *      required={"name, section_id, category_id"}
 * )
 * @OA\Property(property="name", type="string"),
 * @OA\Property(property="section_id", type="integer"),
 * @OA\Property(property="category_id", type="integer"),
 *
 * @property string $name
 * @property string $section_id
 * @property string $category_id
 */
class CaseUpdateRequest extends Request
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
     * @throws Exception
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'section_id' => 'required|integer',
        ];
    }
}
