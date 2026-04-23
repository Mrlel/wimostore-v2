<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
 use Illuminate\Session\TokenMismatchException;

    public function register()
    {
        $this->renderable(function (TokenMismatchException $e, $request) {
            return redirect()->route('login.form')
                ->with('message', 'Session expirée, merci de vous reconnecter.');
        });
    }
}
