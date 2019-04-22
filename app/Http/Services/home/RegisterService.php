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
use Illuminate\Support\Facades\Redis;
use Exception;
use FileUpload;

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

    /**
     * 添加数据
     *
     * @param $data
     */
    public function addData($data)
    {
        $user = $this->model::create($data['user']);

        if(!empty($data['merchant'])) {
            $data['merchant']['uid'] = $user->id;
            $this->merchat::create($data['merchant']);
        }
        return $user;
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
                $res = $this->verifiEnter($data);
                $result['merchant'] = $res;
            break;
            case 3:
                $res = $this->verifiPersonal($data);
                $result['merchant'] = $res;
            break;
            default:
                $result;
            break;
        }
        return $result;
    }

    /**
     * 验证企业商户
     *
     * @param $data
     * @return array
     * @throws Exception
     */
    protected function verifiEnter($data)
    {
        $result = $this->cadrImage($data);
        if(!FileUpload::exists('image', $data['yyzz'])) {
            throw new Exception('营业执照图错误, 请重新上传');
        }
        if(isset($data['food']) && !FileUpload::exists('image', $data['food'])) {
            throw new Exception('食品行业证件图错误, 请重新上传');
        }
        if(isset($data['mrlf']) && !FileUpload::exists('image', $data['mrlf'])) {
            throw new Exception('美容或理发行业图错误, 请重新上传');
        }
        if(isset($data['qt']) && !FileUpload::exists('image', $data['qt'])) {
            throw new Exception('其它行业证件图错误, 请重新上传');
        }
        $result['bus_license'] = $data['yyzz'];
        $result['food_industry'] = isset($data['food'])?? "";
        $result['hairdressing'] = isset($data['mrlf']) ?? "";
        $result['other'] = isset($data['qt']) ?? "";
        $result['category'] = 1;
        return $result;
    }

    /**
     * 验证个人商户
     *
     * @param $data
     * @return array
     * @throws Exception
     */
    public function verifiPersonal($data)
    {
        $result = $this->cadrImage($data);
        if(!FileUpload::exists('image', $data['zuopin'])) {
            throw new Exception('个人证件或作品图错误, 请重新上传');
        }
        $result['personal'] = $data['zuopin'];
        $result['category'] = 2;
        return $result;
    }

    /**
     * 验证身份证
     *
     * @param $data
     * @return array
     * @throws Exception
     */
    protected function cadrImage($data)
    {
        if(!FileUpload::exists('image', $data['zheng'])) {
            throw new Exception('身份证正面图错误, 请重新上传');
        }
        if(!FileUpload::exists('image', $data['fan'])) {
            throw new Exception('身份证反面图错误, 请重新上传');
        }
        return [
            'card_positive' => $data['zheng'],
            'card_opposite' => $data['fan'],
            'shop_name' => trim($data['shopName']),
            'credit_code' => trim($data['shehuiDaima'])
        ];
    }
}
