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
        'ajax/score',
        'ajax/lite',
        'ajax/estimates/add',
        'ajax/reviews/delete',
        'ajax/sendApplication',
        'ajax/getVideo',
        'ajax/price/add',
        'admin/price/del/*'
    ];
}
