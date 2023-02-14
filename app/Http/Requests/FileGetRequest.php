<?php

namespace App\Http\Requests;

/**
 * @OA\Schema(
 *      title="File get request",
 *      description="File data",
 *      type="object",
 *      required={"hash"}
 * )
 * @OA\Property(property="hash", type="string")
 *
 * @property string $hash
 */
class FileGetRequest extends Request
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
            'hash' => "required|string",
        ];
    }
}
