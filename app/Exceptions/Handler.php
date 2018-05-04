<?php

namespace App\Exceptions;

use CloudCreativity\JsonApi\Document\Error;
use CloudCreativity\JsonApi\Exceptions\AuthorizationException;
use CloudCreativity\LaravelJsonApi\Exceptions\HandlesErrors;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use HandlesErrors;

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
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if($this->isJsonApi()) {
            if($exception instanceof AuthorizationException) {
                $exception->addError(new Error(null, null, 403, null, 'Forbidden', 'You are not authorized to perform this action.'));
            }
            return $this->renderJsonApi($request, $exception);
        }

        return parent::render($request, $exception);
    }
}
