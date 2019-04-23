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
                'url' => '',
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
}
