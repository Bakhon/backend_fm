<?php

namespace App\Http\Requests;

use App\Exceptions\ApiException;
use App\Helpers\Responses;
use App\Reference\Constants;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Exception;

/**
 * Class Request
 * @package App\Http\Requests
 */
class Request extends FormRequest
{
    use Responses;

    /**
     * @param Validator $validator
     * @throws Exception
     */
    public function failedValidation(Validator $validator)
    {
        throw new ApiException($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function prepareForValidation()
    {
        if (!$this->limit) {
            $this->limit = Constants::DEFAULT_LIMIT;
            $this->offset = Constants::DEFAULT_OFFSET;
        }
    }
}
