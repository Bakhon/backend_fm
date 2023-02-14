<?php

namespace App\Http\Requests;

/**
 * @property int limit
 * @property int offset
 * @property string search
 */
class FamilyCompositionSearchRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //        if (!Gate::allows('categories_access')) {
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
