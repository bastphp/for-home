<?php

namespace App\Exceptions;

use App\Constants\ErrorCode;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if (env('APP_DEBUG')){
            return parent::render($request, $exception);
        }else{
            if ($exception instanceof AppException || $exception instanceof QueryException) {
                $result = [
                    'code'      => $exception->getCode(),
                    'msg'       => $exception->getMessage(),
                    'data'      => new \stdClass()
                ];
                return new JsonResponse($result, 200);
            }

            if ($exception instanceof NotFoundHttpException) {
                $result = [
                    'code'      => ErrorCode::ROUTE_NOT_FOUNT,
                    'msg'       => 'The uri you request is not found.',
                    'data'      => new \stdClass()
                ];
                return new JsonResponse($result, 200);
            }

            $result = [
                'code'      => 111111,
                'msg'       => $exception->getMessage(),
                'data'      => new \stdClass()
            ];
            return new JsonResponse($result, 200);
        }
    }
}
