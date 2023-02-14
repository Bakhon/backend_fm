<?php

namespace App\Http\Requests;

/**
 * Class CategorySearchRequest
 * @package App\Http\Requests
 *
 * @property string $search
 * @property int $limit
 * @property int $offset
 */
class CategorySearchRequest extends Request
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
