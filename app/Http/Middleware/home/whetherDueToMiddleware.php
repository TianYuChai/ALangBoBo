<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/24
 * Time: 16:04
 */
namespace App\Http\Middleware\home;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Exception;
class whetherDueToMiddleware
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
        if(!auth::guard('web')->user()->merchant_due) {
            throw new Exception('无法操作, 入驻费未缴纳或已到期');
        }
        return $next($request);
    }
}
