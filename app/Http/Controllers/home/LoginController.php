<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/15
 * Time: 18:12
 */
namespace App\Http\Controllers\home;

use App\Http\Models\currency\UserModel;
use App\Http\Services\home\LoginService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
    public function index()
    {
//        dd(auth()->guard('web')->user());
        return view('home.login');
    }

    /**
     * 登陆操作
     * 如用户不符合状态，则进行登出操作
     *
     * @param Request $request
     * @param LoginService $loginService
     * @return \Illuminate\Http\JsonResponse
     */
    public function operation(Request $request, LoginService $loginService)
    {
        try{
            $loginService->dataFiltering($request);
            return $this->ajaxReturn([
                'url' => route('personal.index'),
                'status' => 200
            ], 200);
        } catch (Exception $e) {
            auth()->guard('web')->logout();
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => $e->getCode()
            ], $e->getCode());
        }
    }

    /**
     * 验证账号是否注册
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verfMobile(Request $request)
    {
        try {
            $item = UserModel::where('number', $request->mobile)->first();
            if(!$item) {
                throw new Exception('该账户未注册，请先前往注册');
            }
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => 510
            ], 510);
        }
    }

    /**
     * 退出登陆
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function loginout()
    {
        Auth::guard('web')->logout();
        return redirect(route('index.login'));
    }
}
