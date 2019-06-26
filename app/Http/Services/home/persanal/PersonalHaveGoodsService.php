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
use Exception;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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
        $this->wxconfig = config('wechat.pay');
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
                $result = $shoppPayService->alipay([
                    'order_id' => create_order_no(),
                    'passback_params' => $item->id,
                    'paidin_prices' => $item->moneys,
                ]);
            } else {
                $result = QrCode::size(150)->generate($shoppPayService->wechat([
                    'order_id' => create_order_no(),
                    'attach' => $item->id,
                    'paidin_prices' => $item->money,
                ]));
            }
        } else {
            if($item->timeout == '0000-00-00 00:00:00') {
                throw new Exception('订单已经完成支付');
            }
            if($item->order->pay_method == 'Alipay') {
                $order = [
                    'out_trade_no' => create_order_no(),
                    'total_amount' => $item->moneys,
                    'passback_params' => $item->id,
                    'subject' => '阿郎博波商务中心',
                    'body' => '认缴订单完成支付',
                ];
                $this->config['notify_url'] = route('index.subscribed.notify');
                $this->config['return_url'] = route('personal.havegoods', ['type' => 'allOrder']);
                $result = Pay::alipay($this->config)->web($order);
            } else {
                $order = [
                    'out_trade_no' => create_order_no(),
                    'total_fee' =>  $item->money,
                    'attach' => $item->id,
                    'body' => '阿朗博博商务中心---商品购买',
                ];
                $this->wxconfig['notify_url'] = route('index.subscribed.wxnotify');
                $wechat = Pay::wechat($this->wxconfig)->scan($order);
                $result =  QrCode::size(150)->generate($wechat['code_url']);
            }
        }
        return $result;
    }

    /**
     * 支付宝回调
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
                Log::info('认缴订单支付宝异步回调', [
                    'data' => $data
                ]);
                $item = $this->model::where([
                    'id' => intval($data['passback_params']),
//                    'order_id' => strval($data['out_trade_no']),
                    'pay_method' => 'subscribed'
                ])->where('timeout', '!=', '0000-00-00 00:00:00')->first();
                if($item) {
                    $item->timeout = '';
                    $item->save();
                    if($item->satatus == 500) {
                        $this->capitalModel::create([
                            'uid' => $item->gid,
                            'order_id' => $item->order_id,
                            'g_order_id' => $item->id,
                            'money' => bcsub($item->moneys, $item->satisfiedfees, 2),
                            'trade_mode' => $item->order->pay_method,
                            'memo' => '用户备注:' . empty($item->memo) ? '无, 平台备注: 用户下单支付订单' :
                                $item->memo. ','. '平台备注: 用户下单支付订单',
                            'category' => 500,
                            'status' => 1001,
                            'trans_at' => $item->created_at,
                        ]);
                    }
                }
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

    /**
     * 微信支付回调
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function wxnotify()
    {
        try {
            $vailet = Pay::wechat($this->wxconfig)->verify();
            $data = $vailet->all();
            if($data['return_code'] == 'SUCCESS' || $data['result_code'] == 'SUCCESS'
                && $data['app_id'] == $this->wxconfig['app_id']) {
                Log::info('认缴订单微信支付返回参数', [
                    'data' => $data
                ]);
                $item = $this->model::where([
                    'id' => intval($data['attach']),
//                    'order_id' => strval($data['out_trade_no']),
                    'pay_method' => 'subscribed'
                ])->where('timeout', '!=', '0000-00-00 00:00:00')->first();
                if($item) {
                    $item->timeout = '';
                    $item->save();
                    if($item->satatus == 500) {
                        $this->capitalModel::create([
                            'uid' => $item->gid,
                            'order_id' => $item->order_id,
                            'g_order_id' => $item->id,
                            'money' => bcsub($item->moneys, $item->satisfiedfees, 2),
                            'trade_mode' => $item->order->pay_method,
                            'memo' => '用户备注:' . empty($item->memo) ? '无, 平台备注: 用户下单支付订单' :
                                $item->memo. ','. '平台备注: 用户下单支付订单',
                            'category' => 500,
                            'status' => 1001,
                            'trans_at' => $item->created_at,
                        ]);
                    }
                }
                Log::info('认缴订单微信异步回调处理结束', [
                    'order_id' => $data['out_trade_no']
                ]);
            }
            return Pay::wechat($this->wxconfig)->success();
        } catch (Exception $e) {
            Log::info('认缴订单微信支付回调:', [
                'time' => getTime(),
                'info' => $e->getMessage()
            ]);
        }
    }
}
