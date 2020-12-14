<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use ErrorException;
use HttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use LogicException;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use TypeError;

class Handler extends ExceptionHandler
{
    use ApiResponse;
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
    public function render($request, Throwable $exception)
    {
        $response = $this->handleException($request, $exception);
        return $response;
    }

    public function handleException($request, Throwable $exception)
    {

        if ($exception instanceof ValidationException) {
            return $this->errorResponse($exception->errors(), 'Validation errors', 400);
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->errorResponse(null, 'Not found!', 404);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse(null, 'The specified method for the request is invalid', 405);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse(null, 'The specified URL cannot be found', 404);
        }


        if ($exception instanceof BindingResolutionException) {
            return $this->errorResponse(null, $exception->getMessage(), 500);
        }

        if ($exception instanceof ErrorException) {
            return $this->errorResponse(null, $exception->getMessage(), 500);
        }

        if ($exception instanceof TypeError) {
            return $this->errorResponse(null, $exception->getMessage(), 500);
        }

        if ($exception instanceof LogicException) {
            return $this->errorResponse(null, $exception->getMessage(), 500);
        }

        if ($exception instanceof QueryException) {
            return $this->errorResponse(null, $exception->getMessage(), 500);
        }

        if ($exception instanceof HttpException) {
            return $this->errorResponse(null, $exception->getMessage(), $exception->getStatusCode());
        }

        if ($exception instanceof RuntimeException) {
            return $this->errorResponse(null, $exception->getMessage(), $exception->getStatusCode());
        }

        if ($exception instanceof AccessDeniedHttpException) {
            return $this->errorResponse(null, $exception->getMessage(), $exception->getStatusCode());
        }

        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse(null, $exception->getMessage(), 403);
        }

        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        return $this->errorResponse(null, 'Unexpected Exception. Try later', 500);
    }
}
