<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/5/5
 * Time: 23:13
 */
namespace App\Http\Services\home;

use App\Http\Models\currency\CapitalModel;
use App\Http\Models\home\personal\AddressModel;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Redis;

class PersanalService extends BaseService
{
    protected $userId = null;
    protected $capital;
    protected $address;
    public function __construct(CapitalModel $capital, AddressModel $addressModel)
    {
        $this->userId =  Auth::guard('web')->user()->id;
        $this->capital = $capital;
        $this->address = $addressModel;
    }

    /**
     * 验证短信
     *
     * @param $mobile
     * @param $code
     */
    public function vefiShort($code)
    {
        $mobile = Auth::guard('web')->user()->number;
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
     * 获取用户冻结金额
     *
     * @return mixed
     */
    public function frozenCapital()
    {
        return $this->capital::where([
            'category' => 300,
            'status' => 1001
        ])->sum('money');
    }

    /**
     * 地址信息
     * @return array
     */
    public function address()
    {
        $harvest = $this->harvestAddress();
        $shipping = $this->shippingAddress();
        return [
          'harvests' => [
              'harvest' => $harvest,
              'harvest_count' => $harvest->count()
          ],
          'shippings' => [
              'shipping' => $shipping,
              'shipping_count' => $shipping->count()
          ]
        ];
    }

    /**
     * 获取收货地址
     * @return mixed
     */
    protected function harvestAddress()
    {
        return $this->address::where([
            'uid' => $this->userId,
            'category' => 800
        ])->get();
    }

    /**
     * 获取发货地址
     *
     * @return mixed
     */
    protected function shippingAddress()
    {
        return $this->address::where([
            'uid' => $this->userId,
            'category' => 900
        ])->get();
    }
}
