<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/14
 * Time: 15:28
 */
namespace App\Http\Services\home;

use Yansongda\Pay\Pay;

class AlipayService extends BaseService
{

    public function entrance($money)
    {
        $order = [
            'out_trade_no' => create_order_no(),
            'total_amount' => 0.01,
            'subject' => 'test subject - 测试',
        ];
        $alipay = Pay::alipay(config('alipay.pay'))->web($order);
        return $alipay;
    }
}
