<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/15
 * Time: 9:32
 */

namespace App\Http\Middleware\home;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class whiterloginMiddleware
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
        if(Auth::guard('web')->check()) {
            return redirect()->route('personal.index');
        }
        return $next($request);
    }
}
