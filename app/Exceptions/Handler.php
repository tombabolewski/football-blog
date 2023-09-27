<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
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
        $this->renderable(function (HttpExceptionInterface $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => [
                        'message' => $e->getMessage(),
                        'code' => $e->getCode(),
                    ],
                ], $e->getStatusCode())
                ->withHeaders($e->getHeaders());
            }
        });
        $this->renderable(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => [
                        'message' => 'Validation error. Please check your input and try again.',
                        'fields' => $e->errors(),
                        'code' => $e->getCode(),
                    ],
                ], 422);
            }
        });
        $this->renderable(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => [
                        'message' => 'Unauthenticated',
                        'code' => $e->getCode(),
                    ],
                ], 401);
            }
        });
        $this->renderable(function (ModelNotFoundException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => [
                        'message' => 'Requested resource not found',
                        'code' => $e->getCode(),
                    ],
                ], 404);
            }
        });
        $this->renderable(function (Throwable $e, Request $request) {
            dd($e);
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => [
                        'message' => 'Whoops! Something went wrong.',
                        'code' => $e->getCode(),
                    ],
                ], 500);
            }
        });
    }
}
