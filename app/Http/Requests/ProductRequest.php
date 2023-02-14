<?php

namespace App\Http\Requests;

/**
 * Class ProductRequest
 * @package App\Http\Requests
 *
 * @property int $id
 * @property string $name
 * @property string $description
 */
class ProductRequest extends Request
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
        $rules = [
            'name' => 'required|string',
            'description' => 'required|string',
        ];

        switch ($this->getMethod()) {
            case 'POST':
                return $rules;
            case 'PUT':
                return [
                        'id' => 'required|integer|exists:posts,id',
                    ] + $rules;
            case 'DELETE':
                return [
                    'id' => 'required|integer|exists:posts,id'
                ];
                break;
            default:
                return $rules;
                break;
        }
    }
}
