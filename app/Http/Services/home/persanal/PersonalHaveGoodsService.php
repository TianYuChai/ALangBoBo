<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/10
 * Time: 15:21
 */
namespace App\Http\Services\home\persanal;

use App\Http\Models\currency\CapitalModel;
use App\Http\Models\goods\GoodsModel;
use App\Http\Models\home\orderModel;
use App\Http\Models\home\shoppOrderModel;
use App\Http\Services\home\BaseService;
use App\Http\Services\home\shoppPayService;
use function Couchbase\defaultDecoder;
use Exception;
use Yansongda\Pay\Pay;
use Log;

class PersonalHaveGoodsService extends BaseService
{
    public function __construct(GoodsModel $goodsModel,
                                orderModel $orderModel,
                                shoppOrderModel $shoppOrderModel,
                                CapitalModel $capitalModel)
    {
        parent::__construct();
        $this->goods = $goodsModel;
        $this->orderModel = $orderModel;
        $this->model = $shoppOrderModel;
        $this->capitalModel = $capitalModel;
        $this->config = config('alipay.pay');
    }

    /**
     * 支付
     *
     * @param $id
     * @param shoppPayService $shoppPayService
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws Exception
     */
    public function pay($id)
    {
        $shoppPayService = app()->make(shoppPayService::class);
        $item = $this->model::where([
            'id' => intval($id),
            'uid' => $this->userId,
        ])->first();
        if(!$item) {
            throw new Exception('订单不存在');
        }
        if($item->pay_method == 'paidin') {
            if($item->order->pay_method == 'Alipay') {
                $result = $shoppPayService->alipay($item);
            }
        } else {
            if($item->timeout == '0000-00-00 00:00:00') {
                throw new Exception('订单已经完成支付');
            }
            if($item->order->pay_method == 'Alipay') {
                $order = [
                    'out_trade_no' => $item->order_id,
                    'total_amount' => '1',
                    'extra_common_param' => $item->id,
                    'subject' => '阿郎博波商务中心',
                    'body' => '认缴订单完成支付',
                ];
                $this->config['notify_url'] = route('index.subscribed.notify');
                $this->config['return_url'] = route('personal.havegoods', ['type' => 'allOrder']);
                $result = Pay::alipay($this->config)->web($order);
            }
        }
        return $result;
    }

    /**
     * 回调
     *
     * @return \Symfony\Component\HttpFoundation\Response\
     */
    public function notify()
    {
        try {
            $vailet = Pay::alipay($this->config)->verify();
            $data = $vailet->all();
            if($data['trade_status'] == 'TRADE_SUCCESS' || $data['trade_status'] == 'TRADE_FINISHED'
                && $data['app_id'] == $this->config['app_id']) {
                $item = $this->model::where([
                    'id' => intval($data['extra_common_param']),
                    'order_id' => strval($data['out_trade_no']),
                    'pay_method' => 'subscribed'
                ])->where('timeout', '!=', '0000-00-00 00:00:00')->first();
                $item->timeout = '';
                $item->save();
                $this->capitalModel::where([
                    'order_id' => strval($data['out_trade_no']),
                    'g_order_id' => intval($data['extra_common_param']),
                    'category' => 500,
                    'status' => 1003,
                    'uid' => $item->gid
                ])->update(['status' => 1001]);
                Log::info('认缴订单支付宝异步回调处理结束', [
                    'order_id' => $data['out_trade_no']
                ]);
            }
            return Pay::alipay($this->config)->success();
        } catch (Exception $e) {
            Log::info('支付宝支付回调:', [
                'time' => getTime(),
                'info' => $e->getMessage()
            ]);
        }
    }
}
