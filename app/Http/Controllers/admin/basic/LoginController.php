<?php

namespace App\Http\Controllers\admin\basic;

use App\Http\Controllers\admin\BaseController;
use App\Http\Requests\admin\basic\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
    public function index()
    {
        return view('admin.login');
    }

    /**
     * 登陆处理
     * @param LoginRequest $loginRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(LoginRequest $loginRequest)
    {
        $credentials = $loginRequest->only('username', 'password');
        if (Auth::guard('backstage')->attempt($credentials)) {
            $data = [
                'info' => '登陆成功',
                'url' => route('backage.index.index'),
                'status' => 200
            ];
        } else {
            $data = [
                'info' => '账号或密码错误',
                'status' => 406
            ];
        }
        return $this->ajaxReturn($data, $data['status']);
    }
}
