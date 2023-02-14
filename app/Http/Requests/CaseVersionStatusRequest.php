<?php

namespace App\Http\Requests;

/**
 * @OA\Schema(
 *      title="Case version status request",
 *      description="Case version status request body data",
 *      type="object",
 *      required={"is_active"}
 * )
 * @OA\Property(property="is_active", type="boolean"),
 * @OA\Property(property="case_id", type="integer"),
 *
 * @property boolean $is_active
 * @property integer $case_id
 */
class CaseVersionStatusRequest extends Request
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
            'is_active' => 'required|boolean',
            'case_id' => 'required|integer|exists:cases,id',
        ];
    }
}
