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
        'notify',
        'busin/notify',
        'order/notify',
        'subscribed/order/notify',
        'demand/alinotify',
        'wxnotify',
        'busin/wxnotify',
        'order/wxnotify',
        'subscribed/order/wxnotify',
        'demand/wxnotify'
    ];
}
