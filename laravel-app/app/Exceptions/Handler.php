<?php

namespace App\Exceptions;

use App\Trait\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(
            [
                'error' => [
                    'status' => 401,
                    'message' => 'unauthenticated'
                ]
                ], 401
            );
    }

    /**
     * Reder all exception
     * 
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $e)
    {
        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        switch (true) {
            case $e instanceof ValidationException:
                $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
                break;
            case $e instanceof \Exception:
                break;
            default:
                break;
        }
        return $this->errorResponse($e, $statusCode);
    }
}
