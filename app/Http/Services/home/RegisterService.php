<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/4/17
 * Time: 21:54
 */
namespace App\Http\Services;

use App\Http\Models\currency\UserModel;
use App\Http\Services\home\BaseService;
use Redis;
use Exception;

class RegisterService extends BaseService
{
    protected $model;
    public function __construct(UserModel $model)
    {
        $this->model = $model;
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
        $res = $this->categoryHandleData($category, $data);
        return $res;
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
            'password' => trim($data['password']),
            'category' => intval(trim($data['category'])),
            'name' => trim($data['name']),
            'caid' => trim($data['id']),
            'number' => trim($data['mobile']),
            'type' => intval(trim($data['type']))
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