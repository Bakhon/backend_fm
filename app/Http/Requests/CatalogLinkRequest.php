<?php

namespace App\Http\Requests;

/**
 * @OA\Schema(
 *      title="CatalogLinkRequest",
 *      description="CatalogLink Request body data",
 *      type="object",
 *      required={"section_id", "category_id"}
 * )
 * @OA\Property(property="section_id", type="integer")
 * @OA\Property(property="category_id", type="integer")
 *
 * @property int $section_id
 * @property int $category_id
 */
class CatalogLinkRequest extends Request
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
            'category_id' => 'required|integer|exists:categories,id',
            'section_id' => 'required|integer|exists:sections,id'
        ];
    }
}
