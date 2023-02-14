<?php

namespace App\Http\Requests;

use App\Reference\Constants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

/**
 * @property mixed search
 * @property mixed limit
 * @property mixed offset
 */
class SectionSearchRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        if (!Gate::allows('section_access')) {
//            $this->exceptionResponse(Constants::ERROR_USER_HAS_NO_PERMISSION, Response::HTTP_FORBIDDEN);
//        }
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
