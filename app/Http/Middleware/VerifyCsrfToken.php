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
        // https://medium.com/@kantai_developer/%E5%9C%A8-heroku-%E4%B8%8A%E7%9A%84-laravel-%E5%B0%88%E6%A1%88%E7%AA%81%E7%84%B6%E7%88%86%E6%8E%89-419-page-expired-%E7%9A%84%E8%A7%A3%E6%B1%BA%E6%96%B9%E6%A1%88-87c4137cc787
        "*"
    ];
}
