<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        // TODO: It would be nice to read this from
        //  config. Maybe something like this:
        //  https://laracasts.com/discuss/channels/laravel/define-except-in-middleware-using-env
        '/telegram/webhook/*',

        // ...
    ];
}
