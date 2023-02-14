<?php

namespace App\Http\Requests;

/**
 * Class CatalogCategoryRequest
 * @package App\Http\Requests
 *
 * @property string $search
 * @property int $limit
 * @property int $offset
 */
class CatalogCategoryRequest extends Request
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
            'search' => 'nullable|string',
            'limit' => 'nullable|string',
            'offset' => 'nullable|string',
        ];
    }
}
