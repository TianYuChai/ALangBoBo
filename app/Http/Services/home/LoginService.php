<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/23
 * Time: 15:57
 */
namespace App\Http\Services\home;

use App\Http\Models\admin\RegisterAuditingModel;
use App\Http\Models\currency\MerchantModel;
use App\Http\Models\currency\UserModel;
use Exception;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;

class LoginService extends BaseService
{
    protected static $_TYPE = ['pass', 'short'];
    /**
     * 验证账号
     *
     * @param $data
     */
    public function dataFiltering($data)
    {
        $type = $data['type'];
        if(!in_array($type, self::$_TYPE)) {
            throw new Exception('操作错误, 登陆类型错误');
        }
        if($type == 'short') {
            $this->vefiShort($data['account'], $data['verifyCode']);
            $this->authCodeLogin($data['account']);
        } else {
            $item = $this->passwordLogin([
                'account' => trim($data['account']),
                'password' => trim($data['password'])
            ]);
        }
        if(!$item) {
            throw new Exception('操作错误, 账号不存在');
        }
        $user = auth()->guard('web')->user();
        if($user->status != 1) {
            switch ($user->status) {
                case 0:
                    if(is_null($user->merchant)) {
                        throw new Exception('账号正在审核中, 请耐心等候', 401);
                    } else {
                        throw new Exception('账号已被驳回, 驳回理由:' +
                            $user->registerauditing['reject'] + ', 本站同时已清除该账户注册信息, 请重新进行注册提交', 401);
                        $this->removeAccount($user->id);
//                        $item->delete();
                    }
                    break;
                case 2:
                    throw new Exception('账号或已违反相关规定, 已被封停如需操作请联系本站客服', 510);
                break;
                case 3:
                    throw new Exception('账号已注销, 如需操作请联系本站客服', 510);
                break;
                default:
                    break;
            }
        }
    }
    /**
     * 密码登陆
     *
     * @param $data
     */
    protected function passwordLogin($data)
    {
        return Auth::guard('web')->attempt([
            'account' => $data['account'],
            'password' => $data['password'],
        ]);
    }

    /**
     * 短信验证码登陆
     *
     * @param $account
     */
    protected function authCodeLogin($account)
    {
        return Auth::guard('web')->attempt([
            'number' => $account
        ]);
    }

    /**
     * 验证短信
     *
     * @param $mobile
     * @param $code
     */
    protected function vefiShort($mobile, $code)
    {
        $redisVerifyCode = Redis::get($mobile);
        if(is_null($redisVerifyCode)) {
            throw new Exception('验证码已过期, 请重新发送验证码', 510);
        }
        if($code != $redisVerifyCode) {
            throw new Exception('验证码错误, 请输入正确的验证码', 510);
        }
        Redis::del($mobile);
    }

    /**
     * 清除驳回注册账号
     *
     * @param $uid
     */
    public function removeAccount($uid)
    {
        $where = ['uid' => intval($uid)];
        MerchantModel::where($where)->delete();
        RegisterAuditingModel::where($where)->delete();
    }
}
