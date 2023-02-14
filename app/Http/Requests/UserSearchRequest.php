<?php

namespace App\Http\Requests;

/**
 * Class UserSearchRequest
 * @package App\Http\Requests
 *
 * @property string $search
 */
/**
 * @OA\Schema(
 *      title="User search request",
 *      description="User request body data",
 *      type="object"
 * )
 * @OA\Property(property="limit", type="integer")
 * @OA\Property(property="offset", type="integer")
 *
 * @property string $limit
 * @property string $offset
 */
class UserSearchRequest extends Request
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
            'limit' => 'nullable|integer',
            'offset' => 'nullable|integer',
            'search' => 'nullable|string',
        ];
    }
}
