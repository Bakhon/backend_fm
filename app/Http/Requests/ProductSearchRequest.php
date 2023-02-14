<?php

namespace App\Http\Requests;

use App\Reference\Constants;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;

/**
 * Class PostSearchRequest
 * @package App\Http\Requests
 *
 * @property string $search
 * @property int $limit
 * @property int $offset
 */
class ProductSearchRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!Gate::allows('products_access')) {
            $this->exceptionResponse(Constants::ERROR_USER_HAS_NO_PERMISSION, Response::HTTP_FORBIDDEN);
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (!$this->limit) {
            $this->limit = Constants::DEFAULT_LIMIT;
            $this->offset = Constants::DEFAULT_OFFSET;
        }

        return [
            'limit' => 'nullable|integer',
            'offset' => 'nullable|integer',
            'search' => 'nullable|string',
        ];
    }
}
