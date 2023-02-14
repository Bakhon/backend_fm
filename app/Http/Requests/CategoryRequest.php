<?php

namespace App\Http\Requests;


use App\Models\Category;

/**
 * @OA\Schema(
 *      title="Category request",
 *      description="Category request body data",
 *      type="object",
 *      required={"full_name", "name", "services"}
 * )
 * @OA\Property(property="section_ids", type="array",
 *     @OA\Items(type="integer"),
 * )
 * @OA\Property(property="full_name", type="string", example="Алюминиевые ограждения")
 * @OA\Property(property="name", type="string", example="Алюминиевые ограждения")
 * @OA\Property(property="parent_id", type="integer", example=null)
 * @OA\Property(property="creator_id", type="integer", example=null)
 * @OA\Property(property="version", type="integer", example=2)
 * @OA\Property(property="_ltr", type="integer", example=3, default=0)
 * @OA\Property(property="_rgt", type="integer", example=2, default=0)
 * @OA\Property(property="system", type="string", example=null)
 * @OA\Property(property="number", type="string", example=null)
 * @OA\Property(property="key", type="string", example=null)
 *
 * @property array $section_ids
 * @mixin Category
 */
class CategoryRequest extends Request
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
            'section_ids.*' => 'required|integer|exists:sections,id',
            'full_name' => 'required|string',
            'name' => 'required|string',

            'parent_id' => 'nullable|integer',
            'creator_id' => 'nullable|integer',
            'version' => 'nullable|integer',
            'system' => 'nullable|string',
            'number' => 'nullable|integer',
            'key' => 'nullable|integer',
            '_ltr' => 'nullable|integer',
            '_rgt' => 'nullable|integer'
        ];
    }
}
