<?php

namespace App\Http\Requests;

/**
 * Class ReportSearchRequest
 * @package App\Http\Resources
 *
 * @OA\Schema(
 *     title="ReportSearch Resource"
 * ),
 * @OA\Property(property="search", type="string")
 * @OA\Property(property="status_id", type="integer")
 * @OA\Property(property="date_created_from", type="string")
 * @OA\Property(property="date_created_to", type="string")
 * @OA\Property(property="user_hash", type="string")
 * @OA\Property(property="order_by", type="string")
 * @OA\Property(property="direction", type="string")
 * @OA\Property(property="limit", type="integer")
 * @OA\Property(property="offset", type="integer")
 *
 * @property int $limit
 * @property int $offset
 * @property string $order_by
 * @property string $direction
 * @property string $search
 * @property bool $without_limit
 * @property int $status_id
 * @property string $date_created_from
 * @property string $date_created_to
 * @property string $user_hash
 */
class ReportSearchRequest extends Request
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
            'order_by' => 'nullable|string',
            'direction' => 'nullable|string',
            'limit' => 'nullable|string',
            'offset' => 'nullable|string',
            'without_limit' => 'nullable|bool',
            'search' => 'nullable|string',
            'status_id' => 'nullable|integer',
            'date_created_from' => 'nullable|string',
            'date_created_to' => 'nullable|string',
            'user_hash' => 'nullable|string',
        ];
    }
}
