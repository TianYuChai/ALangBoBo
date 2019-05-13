<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/13
 * Time: 15:39
 */
namespace App\Http\Middleware\home;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class listenStateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::guard('web')->check() && Auth::guard('web')->user()->status != 1) {
            Auth::guard('web')->logout();
            return redirect(route('index.login'));
        }
        return $next($request);
    }
}
