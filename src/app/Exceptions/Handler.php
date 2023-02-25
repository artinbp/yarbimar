<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
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
        $this->renderable(function (ModelNotFoundException $e, $request) {
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json(['message' => 'Item Not Found'], Response::HTTP_NOT_FOUND);
            }
        });

//        $this->renderable(function (NotFoundHttpException $e, $request) {
//            if ($request->wantsJson() || $request->is('api/*')) {
//                return response()->json(['message' => 'The requested link or item does not exist'], Response::HTTP_NOT_FOUND);
//            }
//        });

        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json(['message' => 'unauthenticated'], 401);
            }
        });
    }
}
