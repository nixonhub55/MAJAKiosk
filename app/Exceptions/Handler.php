<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($this->isHttpException($exception) && $exception->getStatusCode() == 500) {
            return redirect('/server-error');
        } 

        return parent::render($request, $exception);
    }
}