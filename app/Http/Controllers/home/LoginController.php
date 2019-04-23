<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/15
 * Time: 18:12
 */
namespace App\Http\Controllers\home;

use App\Http\Services\home\LoginService;
use Illuminate\Http\Request;
use Exception;

class LoginController extends BaseController
{
    public function index()
    {
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
}
