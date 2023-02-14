<?php

namespace App\Http\Requests;


/**
 * @OA\Schema(
 *      title="Family composition request",
 *      description="Family composition request body data",
 *      type="object",
 *      required={"item_name", "extension", "template", "required"}
 * )
 *
 * @OA\Property(property="item_name", type="string",example="Разработанное семейство в формате *.rfa.")
 * @OA\Property(property="description", type="string",example="Подробное описание единицы состава семейства")
 * @OA\Property(property="extension", type="string",example="rfa")
 * @OA\Property(property="template", type="string",example=".rfa")
 * @OA\Property(property="required", type="boolean",example=true)
 *
 * @property string $item_name
 * @property string $description
 * @property string $extension
 * @property string $template
 * @property boolean $required
 */
class FamilyCompositionRequest extends Request
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
            'item_name' => 'required|string',
            'description' => 'nullable|string',
            'extension' => 'required|string',
            'template' => 'required|string',
            'required' => 'required|boolean'
        ];
    }
}
