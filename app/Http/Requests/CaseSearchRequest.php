<?php

namespace App\Http\Requests;

/**
 * Class CaseSearchRequest
 * @package App\Http\Requests
 *
 * @property string $search
 * @property int $category_id
 * @property int $service_id
 * @property int $status_id
 * @property string $date_from
 * @property string $date_to
 * @property int $limit
 * @property int $offset
 * @property string $order_by
 * @property string $direction
 */
class CaseSearchRequest extends Request
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
        $this->status_id = $this->status_id ? (int)$this->status_id : null;

        return [
            'search' => 'nullable|string',
            'category_id' => 'nullable|integer|exists:categories,id',
            'service_id' => 'nullable|integer|exists:services,id',
            'status_id' => 'nullable|integer',
            'date_from' => 'nullable|string',
            'date_to' => 'nullable|string',
            'order_by' => 'nullable|string',
            'direction' => 'nullable|string',
            'limit' => 'nullable|string',
            'offset' => 'nullable|string',
        ];
    }
}
