<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ThrowableHandler;
use Illuminate\Support\Facades\Auth;

class Handler extends ThrowableHandler
{
    /**
     * A list of the Throwable types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation Throwables.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an Throwable.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an Throwable into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function render($request, Throwable $exception)
    {
        if (!Auth::check() && $this->isHttpException($exception)) {
            return redirect()->route('login');
        }

        return parent::render($request, $exception);
    }
}
