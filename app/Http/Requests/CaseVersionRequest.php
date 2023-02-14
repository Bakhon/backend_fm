<?php

namespace App\Http\Requests;

/**
 * @OA\Schema(
 *      title="Case version request",
 *      description="Case version request body data",
 *      type="object",
 *      required={"case_hash, version"}
 * )
 * @OA\Property(property="case_hash", type="string"),
 * @OA\Property(property="version", type="string"),
 *
 * @property string $case_hash
 * @property string $version
 */
class CaseVersionRequest extends Request
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
            'case_hash' => 'required|string|exists:cases,guid',
            'version' => 'required|string',
        ];
    }
}
