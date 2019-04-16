<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/15
 * Time: 18:14
 */
namespace App\Http\Controllers\home;

use App\Http\Models\currency\UserModel;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use Exception;

class RegisterController extends BaseController
{
    public function index()
    {
        return view('home.register');
    }

    public function verifivWhetExist(Request $request)
    {
        try {
            $item = UserModel::where([
                'account' => $request->account
            ])->where('status', '!=', 3)->first();
            if($item) {
                return $this->ajaxReturn([
                    'info' => '账户已存在',
                    'status' => 510
                ], 510);
            }
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => 100
            ], 510);
        }
    }
    /**
     * 短信验证码
     *
     * @param Request $request
     */
    public function shortMessage(Request $request)
    {

    }

}
