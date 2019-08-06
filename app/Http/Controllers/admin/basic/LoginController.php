<?php

namespace App\Http\Controllers\admin\basic;

use App\Http\Controllers\admin\BaseController;
use App\Http\Models\admin\BackstageModel;
use App\Http\Requests\admin\basic\LoginRequest;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
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
                'url' => route('backstage.index.index'),
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

    public function logout()
    {
        Auth::guard('backstage')->logout();
        return redirect(route('login'));
    }

    /**
     * 修改密码
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function editPass(Request $request)
    {
        try {
           BackstageModel::where('id', 1)->update([
               'password' => bcrypt(trim($request->edit_pass))
           ]);
            Auth::guard('backstage')->logout();
            return $this->ajaxReturn();
        } catch (\Exception $e) {
            return $this->ajaxReturn([
                'info' => '密码只能为中英文集合',
                'status' => 406
            ], 406);
        }
    }
}
