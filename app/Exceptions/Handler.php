<?php

namespace App\Exceptions;

use App\Traits\ResponseTraits;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseTraits;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->renderable(function (Exception $exception, Request $request) {
            return $this->customExceptionHandeller($exception, $request);
        });
    }

    public function customExceptionHandeller(Exception $exception, Request $request)
    {
        if ($exception instanceof ValidationException) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST, $this->getErrors($exception->errors()));
        }

        if ($exception instanceof RegistrationFailException) {
            return $this->error($exception->getMessage(), $exception->getCode());
        }
    }

    private function getErrors(array $errorArr): array
    {
        return array_map(function ($message, $key) {
            return [
                'label'   => $key,
                'detail' => $message[0],
            ];
        }, $errorArr, array_keys($errorArr));
    }
}
