<?php

namespace App\Helpers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Trait Responses
 * @package App\Helpers
 */
trait Responses
{
    /**
     * @param $data
     * @param int $code
     * @return JsonResponse
     */
    public function successResponseWithData($data, $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json(
            [
                'status' => true,
                'data' => $data
            ],
            $code,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
    }

    /**
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse($code = Response::HTTP_NO_CONTENT): JsonResponse
    {
        return response()->json(['status' => true], $code,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param $messages
     * @param int $code
     */
    public function exceptionResponse($messages, $code = Response::HTTP_OK)
    {
        $response = response()->json(
            [
                'status' => false,
                'messages' => $messages
            ],
            $code,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
        throw new HttpResponseException($response);
    }
}
