<?php

namespace App\Http\Requests;

/**
 * @OA\Schema(
 *      title="Family request",
 *      description="Family request body data",
 *      type="object",
 *      required={"family_name", "guid", "version"}
 * )
 * @OA\Property(property="family_name", type="string", example="M_Supply Diffuser"),
 * @OA\Property(property="guid", type="string", example="00000000-0000-0000-0000-000000000000"),
 * @OA\Property(property="version", type="integer", example=1),
 *
 * @property string $family_name
 * @property string $guid
 * @property int $version
 */
class FamilyRequest extends Request
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
            'family_name' => 'required|string',
            'guid' => 'required|string',
            'version' => 'required|integer',
        ];
    }
}
