<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/15
 * Time: 18:12
 */
namespace App\Http\Controllers\home;

ini_set("error_reporting","E_ALL & ~E_NOTICE");

use App\Http\Models\currency\UserModel;
use App\Http\Services\home\LoginService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Log;

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
                'url' => !empty(session('url.intended')) ? session('url.intended') : route('personal.index'),
                'status' => 200
            ], 200);
        } catch (Exception $e) {
            auth()->guard('web')->logout();
            Log::info('登陆日志', [
                'info' => $e->getMessage()
            ]);
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => $e->getCode() == 0 ? 500 : $e->getCode()
            ], $e->getCode() == 0 ? 500 : $e->getCode());
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
            $type = $request->type;
            if(!in_array($type, ['number', 'account'])) {
                throw new Exception('类型错误');
            }
            $item = UserModel::where($type , $request->val)->first();
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
        return redirect('/');
    }

    /**
     * 忘记密码
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function forgetPass()
    {
        return view('home.forgetPass');
    }

    /**
     * 忘记密码处理
     *
     * @param Request $request
     * @param LoginService $loginService
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleForgetPass(Request $request, LoginService $loginService)
    {
        try {
            $mobile = trim($request->mobile);
            $code = trim($request->verifyCode);
            $password = trim($request->password);
            if(!is_mobile($mobile)) {
                throw new Exception('请输入正确的手机号码');
            }
            if(stringLen($password) < 6 || stringLen($password) > 12) {
                throw new Exception('密码长度错误, 请重新输入');
            }
            $item = UserModel::where('number', $mobile)->first();
            if(!$item) {
                throw new Exception('该手机号，并未绑定账户');
            }
            if($item->status != 1) {
                throw new Exception('该账户目前不可进行密码修改');
            }
            $status = $loginService->vefiShort($mobile, $code);
            if($status) {
                $item->password = bcrypt(trim($password));
                $item->save();
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
