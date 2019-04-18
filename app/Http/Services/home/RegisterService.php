<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/4/17
 * Time: 21:54
 */
namespace App\Http\Services\home;

use App\Http\Models\currency\MerchantModel;
use App\Http\Models\currency\UserModel;
use App\Http\Services\home\BaseService;
use Redis;
use Exception;

class RegisterService extends BaseService
{
    protected $model;
    protected $merchat;
    public function __construct(UserModel $model, MerchantModel $merchantModel)
    {
        $this->model = $model;
        $this->merchat = $merchantModel;
    }

    /**
     * 数据过滤
     *
     * @param $data
     * @return mixed
     * @throws Exception
     */
    public function dataFiltering($data)
    {
        $mobile = $data['mobile'];
        $verifyCode = intval($data['verifyCode']);
        $this->verifyCode($mobile, $verifyCode);
        $category = intval(trim($data['category']));
        $res = $this->categoryHandleData($category, $data->toArray());
        return $res;
    }
    public function addData($data)
    {
        $user = $this->model::create($data['user']);

        if(!empty($data['merchant'])) {
            $data['merchant']['uid'] = $user->id;
            $this->merchat::create($data['merchant']);
        }
    }
    /**
     * 验证验证码
     *
     * @param $mobile
     * @param $verifyCode
     * @throws Exception
     */
    protected function verifyCode($mobile, $verifyCode)
    {
        $redisVerifyCode = Redis::get($mobile);
        if(is_null($redisVerifyCode)) {
            throw new Exception('验证码已过期, 请重新发送验证码');
        }
        if($verifyCode != $redisVerifyCode) {
            throw new Exception('验证码错误, 请输入正确的验证码');
        }
        Redis::del($mobile);
    }

    /**
     * 根据注册类别的不同，进行不同的数据处理过程
     * 商家需要有商家编号
     * 
     * @param int $category
     * @param array $data
     * @return mixed
     */
    protected function categoryHandleData(int $category, array $data)
    {
        $result['user'] = [
            'account' => trim($data['account']),
            'password' => bcrypt(trim($data['password'])),
            'category' => intval(trim($data['category'])),
            'name' => trim($data['name']),
            'card' => trim($data['id']),
            'number' => trim($data['mobile']),
            'type' => intval(trim($data['type'])),
            'status' => $data['category'] == '0' ? 1 : 0
        ];
        switch ($category) {
            case 1:
                $result;
            break;
            case 2:
                $result['merchant'] = [

                ];
            break;
            case 3:
                $result['merchant'] = [

                ];
            break;
            default:
                $result;
            break;
        }
        return $result;
    }
}
