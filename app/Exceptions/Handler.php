<?php

namespace App\Exceptions;

use App\Mail\errorMail;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Mail;
use Throwable;

class Handler extends ExceptionHandler
{
    // use Throwable - you should NOT import Throwable class as a trait here. You need to just import it above the class
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {
        $url = $request->url();
        dd($exception);
        return redirect($url);

    }
}
