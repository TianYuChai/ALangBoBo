<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/5
 * Time: 17:01
 */
namespace App\Http\Services\home\persanal;

use App\Http\Models\home\orderModel;
use App\Http\Models\home\shoppOrderModel;
use App\Http\Services\home\BaseService;
use Illuminate\Support\Facades\Auth;
use Exception;
use Yansongda\Pay\Pay;

class PersonalOrderService extends BaseService
{
    public function __construct(shoppOrderModel $model, orderModel $orderModel)
    {
        parent::__construct();
        $this->user = Auth::guard('web')->user();
        $this->model = $model;
        $this->orderModel = $orderModel;
        $this->config = config('alipay.pay');
    }


    public function refund($id)
    {
        $item = $this->model::where([
            'id' => intval($id),
            'gid' => $this->user->id,
            'status' => 700
        ])->first();
        if(!$item) {
            throw new Exception('订单不存在, 请刷新重试');
        }
        if($item->pay_method == 'subscribed' && $item->timeout != '0000-00-00 00:00:00') {
            throw new Exception('认缴单, 用户未完成支付，无法进行退款');
        }
        $order = $this->orderModel::where('order_id', $item->order_id)->first();
        if($order->timeout < getTime()) {
            throw new Exception('该订单已超出可退款期限');
        }
        if(bcsub($order->total_price, $order->refund) < $item->money) {
            throw new Exception('该订单已超出可退款金额');
        }
        $item->status = 800;
        $item->save();
        if($order->pay_method == 'Alipay') {
            $this->alipayRefunds($item);
        } else {

        }
    }

    /**
     * 阿里退款
     *
     * @param $data
     * @return bool
     * @throws \Yansongda\Pay\Exceptions\GatewayException
     * @throws \Yansongda\Pay\Exceptions\InvalidConfigException
     * @throws \Yansongda\Pay\Exceptions\InvalidSignException
     */
    public function alipayRefunds($data)
    {
        $order = [
            'out_trade_no' => $data->order_id,
            'refund_amount' => $data->moneys,
            'out_request_no' => $data->id,
            'refund_reason' => '订单退款'
        ];
        $alipay = Pay::alipay($this->config)->refund($order);
        dd($alipay);
    }

}
