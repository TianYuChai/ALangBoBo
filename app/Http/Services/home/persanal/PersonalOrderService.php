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
use Log;

class PersonalOrderService extends BaseService
{
    public function __construct(shoppOrderModel $model, orderModel $orderModel)
    {
        parent::__construct();
        $this->user = Auth::guard('web')->user();
        $this->model = $model;
        $this->orderModel = $orderModel;
        $this->config = config('alipay.pay');
        $this->wxconfig = config('wechat.pay');
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
            $this->wechatRefunds($item);
        }
    }

    /**
     * 支付宝退款
     *
     * @param $data
     * @return bool
     * @throws \Yansongda\Pay\Exceptions\GatewayException
     * @throws \Yansongda\Pay\Exceptions\InvalidConfigException
     * @throws \Yansongda\Pay\Exceptions\InvalidSignException
     */
    public function alipayRefunds($data)
    {
        try{
            $order = [
                'out_trade_no' => $data->order_id,
                'refund_amount' => '0.5',
                'out_request_no' => $data->id,
                'refund_reason' => '订单退款'
            ];
            $alipay = Pay::alipay($this->config)->refund($order);
            if($alipay['msg'] == 'Success') {
                $data->status = 900;
                $data->save();
            }
            return true;
        } catch (Exception $e) {
            Log::info('支付宝-退款操作', [
                'time' => getTime(),
                'id' => $data->id,
                'order_id' => $data->order_id,
                'info' => $e->getMessage()
            ]);
            throw new Exception('退款错误, 请联系管理员');
        }
    }

    /**
     * 微信退款
     *
     * @param $data
     * @return bool
     * @throws Exception
     */
    public function wechatRefunds($data)
    {
        try {
            $order = [
                'out_trade_no' => $data->order_id,
                'out_refund_no' => create_order_no(),
                'total_fee' => $data->order->total_price,
                'refund_fee' => $data->money,
                'refund_desc' => '商家订单退款',
            ];
            $wechat = Pay::wechat($this->wxconfig)->refund($order);
            if($wechat['return_code'] == 'SUCCESS') {
                $data->status = 900;
                $data->save();
            }
            return true;
        } catch (Exception $e) {
            Log::info('微信-退款操作', [
               'time' => getTime(),
               'id' => $data->id,
               'order_id' => $data->order_id,
               'info' => $e->getMessage()
            ]);
            throw new Exception('退款错误, 请联系管理员');
        }
    }
}
