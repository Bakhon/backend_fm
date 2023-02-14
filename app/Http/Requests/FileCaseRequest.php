<?php

namespace App\Http\Requests;

/**
 * @OA\Schema(
 *      title="File request",
 *      description="File request body data",
 *      type="object",
 *      required={"file"}
 * )
 * @OA\Property(property="file", type="file")
 * @OA\Property(property="case_hash", type="string")
 *
 * @property object $file
 * @property string $case_hash
 */
class FileCaseRequest extends Request
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
            'file' => "required|file|max:" . config('file.max_size'),
            'case_hash' => "required|string",
        ];
    }
}
