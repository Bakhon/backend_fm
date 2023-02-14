<?php

namespace App\Exceptions;

use App\Helpers\Responses;
use App\Reference\Constants;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    use Responses;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Return json response for only API 404 error
     *
     * @param \Illuminate\Http\Request $request
     * @param Throwable $exception
     * @return \Illuminate\Http\JsonResponse|Response|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            $this->exceptionResponse(Constants::ACTION_NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof ModelNotFoundException) {
            $this->exceptionResponse(Constants::MODEL_NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof ApiException) {
            $this->exceptionResponse($exception->getMessage(), $exception->getCode());
        }

        return parent::render($request, $exception);
    }
}
