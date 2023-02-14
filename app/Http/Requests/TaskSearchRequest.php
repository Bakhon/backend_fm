<?php

namespace App\Http\Requests;

/**
 * Class TaskSearchRequest
 * @package App\Http\Requests
 *
 * @property string $search
 * @property int $limit
 * @property int $offset
 * @property string $order_by
 * @property string $direction
 * @property bool $without_limit
 * @property int $status_id
 * @property string $date_created_from
 * @property string $date_created_to
 * @property string $date_updated_from
 * @property string $date_updated_to
 * @property string $user_hash
 */
class TaskSearchRequest extends Request
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
            'order_by' => 'nullable||string',
            'direction' => 'nullable||string',
            'limit' => 'nullable|string',
            'offset' => 'nullable|string',
            'without_limit' => 'nullable|bool',
            'status_id' => 'nullable|integer',
            'date_created_from' => 'nullable|string',
            'date_created_to' => 'nullable|string',
            'date_updated_from' => 'nullable|string',
            'date_updated_to' => 'nullable|string',
            'user_hash' => 'nullable|string',
        ];
    }
}
