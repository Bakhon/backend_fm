<?php

namespace App\Http\Requests;

/**
 * @OA\Schema(
 *      title="RegData request",
 *      description="RegData request body data",
 *      type="object",
 *      required={"name"}
 * )
 * @OA\Property(property="RegNumber", type="string", example="e8490d90-b4b0-4295-9a6e-807c88711446"),
 * @OA\Property(property="Version", type="integer", example=1),
 *
 * @property string $RegNumber
 * @property int $Version
 */
class RegDataRequest extends Request
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
            'RegNumber' => 'required|string',
            'Version' => 'required|integer'
        ];
    }
}
