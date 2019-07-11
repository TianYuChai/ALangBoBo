<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/31
 * Time: 14:17
 */
namespace App\Http\Services\home;

use App\Http\Models\currency\CapitalModel;
use App\Http\Models\goods\GoodsModel;
use App\Http\Models\home\orderModel;
use App\Http\Models\home\personal\AddressModel;
use App\Http\Models\home\shareStatisticsModel;
use App\Http\Models\home\shoppOrderModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yansongda\Pay\Pay;

class shoppPayService extends BaseService
{
    public function __construct(GoodsModel $goodsModel,
                                orderModel $orderModel,
                                shoppOrderModel $shoppOrderModel,
                                CapitalModel $capitalModel,
                                shareStatisticsModel $shareStatisticsModel,
                                AddressModel $addressModel)
    {
        parent::__construct();
        $this->goods = $goodsModel;
        $this->orderModel = $orderModel;
        $this->shopp_orderModel = $shoppOrderModel;
        $this->capitalModel = $capitalModel;
        $this->shareStatisticsModel = $shareStatisticsModel;
        $this->addressModel = $addressModel;
        $this->config = config('alipay.pay');
        $this->wxconfig = config('wechat.pay');
    }

    public function entrance($order_id, $data)
    {
        $this->merchantOrderAddressMemo($order_id, $data);
        $this->generateFlowSheet($order_id, $data);
        $item = $this->orderModel::where([
            'order_id' => $order_id,
            'status' => 2001
        ])->first();
        $item->pay_method = $data['method'];
        $item->save();
        if($item->paidin_price == '0') {
            return $this->subscribedWith($order_id);
        } else {
            if($item->subscribed_price != '0'){
                $this->subscribedWith($order_id);
            };
            if($data['method'] == 'Alipay') {
                return $this->alipay($item);
            } else if($data['method'] == 'WeChat'){
                $result = $this->wechat($item);
                return QrCode::size(150)->generate($result);
            } else {
                throw new Exception('支付类型错误, 请重新选择', 510);
            }
        }
    }

    /**
     * 更新商家订单收货地址以及备注信息
     *
     * @param $order_id
     * @param $data
     * @throws Exception
     */
    protected function merchantOrderAddressMemo($order_id, $data)
    {
        try {
            $items = $this->shopp_orderModel::where('order_id', $order_id)->get();
            $address = $this->addressModel::where('id', $data['address'])->first([
                'address', 'detailed', 'code', 'number', 'contacts',
            ]);
            if(!empty($data['memo'])) {
                foreach ($data['memo'] as $datum) {
                    $item = $items->where('id', intval($datum['id']))->first();
                    $item->address = json_encode($address);
                    $item->memo = $datum['val'];
                    $item->save();
                }
            } else {
                foreach ($items as $item) {
                    $item = $items->where('id', intval($item->id))->first();
                    $item->address = json_encode($address);
                    $item->save();
                }
            }
        } catch (Exception $e) {
            Log::info('商家订单添加收货地址以及备注: ', [
                'order_id' => $order_id,
                'time' => getTime(),
                'info' => $e->getMessage(),
                'data' => $data
            ]);
            throw new Exception('请联系管理员', 510);
        }
    }

    /**
     * 根据订单进行处理
     *
     * 1.生成支付流水单
     * 2.生成分享用户数据统计单
     *
     * @param $order_id
     * @param $data
     * @throws Exception
     */
    protected function generateFlowSheet($order_id, $data)
    {
        DB::beginTransaction();
        try {
//            $capitai = [];
            $share = [];
            $items = $this->shopp_orderModel::where([
                'order_id' => $order_id,
//                'pay_method' => 'paidin',
                'status' => 200
            ])->get();
            foreach ($items as $item) {
//                $capitai[] = [
//                    'uid' => $item->gid,
//                    'order_id' => $item->order_id,
//                    'g_order_id' => $item->id,
//                    'money' => $item->moneys,
//                    'trade_mode' => $data['method'],
//                    'memo' => '用户备注:' . empty($item->memo) ? '无, 平台备注: 用户下单支付订单' : $item->memo. ','. '平台备注: 用户下单支付订单',
//                    'category' => 500,
//                    'status' => 1003,
//                    'trans_at' => getTime(),
//                    'created_at' => getTime(),
//                    'updated_at' => getTime()
//                ];
                if($item->referees) {
                    $share[] = [
                        'gid' => $item->gid,
                        'share_id' => $item->referees,
                        'order_id' => $item->order_id,
                        'g_order_id' => $item->id,
                        'status' => 200,
                        'created_at' => getTime(),
                        'updated_at' => getTime()
                    ];
                }
            }
//            $this->capitalModel::insert($capitai);
            if(!empty($share)) {
                $this->shareStatisticsModel::insert($share);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('生成商家订单支付流水单：', [
                'order_id' => $order_id,
                'time' => getTime(),
                'info' => $e->getMessage()
            ]);
            throw new Exception('请联系管理员', 510);
        }
    }

    /**
     * 订单认缴模式
     *
     * 将订单下认缴订单进行处理
     *
     * @param $data
     */
    protected function subscribedWith($data)
    {
        try {
            $this->shopp_orderModel::where([
                'order_id' => $data,
                'pay_method' => 'subscribed',
                'status' => 200
            ])->update([
                'status' => 300,
                'timeout' => Carbon::now()->modify('+30 days')->toDateTimeString()
            ]);
            return ['info' => '支付完成', 'url' => route('personal.havegoods', ['type' => 'allOrder'])];
        } catch (Exception $e) {
            Log::info('认缴订单处理流程：', [
               'time' => getTime(),
               'order_id' => $data,
               'info' => $e->getMessage()
            ]);
            throw new Exception('请联系管理员', 510);
        }
    }

    /**
     * 支付宝支付
     *
     * @param $data
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws Exception
     */
    public function alipay($data)
    {
        try {
            $order = [
                'out_trade_no' => $data['order_id'],
                'total_amount' => $data['paidin_prices'],
                'subject' => '阿郎博波商务中心',
                'body' => '商品购买',
            ];
            if(isset($data['passback_params'])) {
                $order['passback_params '] = $data['passback_params '];
            }
            $this->config['notify_url'] = route('index.order.notify');
            $this->config['return_url'] = route('personal.creditmargin');
            $alipay = Pay::alipay($this->config)->web($order);
            return $alipay;
        } catch (Exception $e) {
            Log::info('支付宝订单支付：', [
                'time' => getTime(),
                'order_id' => $data->order_id,
                'info' => $e->getMessage()
            ]);
            throw new Exception('请联系管理员', 510);
        }
    }

    /**
     * 微信支付
     *
     * @param $data
     * @throws Exception
     */
    public function wechat($data)
    {
        try {
            $order = [
                'out_trade_no' => $data['order_id'],
                'total_fee' => $data['paidin_prices'],
                'body' => '阿朗博博商务中心---商品购买',
            ];
            if(isset($data['attach'])) {
                $order['attach'] = $data['attach'];
            }
            $this->wxconfig['notify_url'] = route('index.order.wxnotify');
            $wechat = Pay::wechat($this->wxconfig)->scan($order);
            return $wechat['code_url'];
        } catch (Exception $e) {
            Log::info('微信订单支付:', [
                'time' => getTime(),
                'order_id' => $data->order_id,
                'info' => $e->getMessage()
            ]);
            throw new Exception('请联系管理员', 510);
        }
    }

    /**
     * 订单支付回调
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Yansongda\Pay\Exceptions\InvalidConfigException
     * @throws \Yansongda\Pay\Exceptions\InvalidSignException
     */
    public function notify()
    {
        try {
            $vailet = Pay::alipay($this->config)->verify();
            $data = $vailet->all();
            if($data['trade_status'] == 'TRADE_SUCCESS' || $data['trade_status'] == 'TRADE_FINISHED'
                && $data['app_id'] == $this->config['app_id']) {
                    if(isset($data['passback_params ']) && !empty($data['passback_params '])) {
                        $this->processing($data['passback_params'], $data['out_trade_no']);
                    } else {
                        $item = $this->orderModel::where([
                            'order_id' => strval($data['out_trade_no']),
                            'status' => 2001
                        ])->first();
                        $item->status = 2101;
                        $item->timeout = Carbon::now()->modify('+30 days')->toDateTimeString();
                        $item->save();
                    }
                Log::info('订单支付宝异步回调处理结束', [
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
     * 微信回调
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
                Log::info('微信商品支付返回参数', [
                    'data' => $data
                ]);
                if(isset($data['attach']) && !empty($data['attach'])) {
                    $this->processing($data['attach'], $data['out_trade_no']);
                } else {
                    $item = $this->orderModel::where([
                        'order_id' => strval($data['out_trade_no']),
                        'status' => 2001
                    ])->first();
                    $item->status = 2101;
                    $item->timeout = Carbon::now()->modify('+30 days')->toDateTimeString();
                    $item->save();
                }
                Log::info('订单微信回调处理结束', [
                    'order_id' => $data['out_trade_no']
                ]);
            }
            return Pay::wechat($this->wxconfig)->success();
        } catch (Exception $e) {
            Log::info('微信支付回调:', [
                'time' => getTime(),
                'info' => $e->getMessage()
            ]);
        }
    }

    /**
     * 子订单支付
     *
     * @param $id
     * @param $order_id
     */
    public function processing($id, $order_id)
    {
        try {
            $item = $this->shoppOrderModel::where([
                'id' => intval($id),
                'status' => 200
            ])->first();
            $orders = $this->shoppOrderModel::where([
                'order_id' => strval($item->order_id),
                'status' => 200
            ])->where('id', '!=', $item->id)->get();
            if($orders->isEmpty()) {
                $this->orderModel::where([
                    'order_id' => strval($item->order_id),
                    'status' => 2001
                ])->first()->update([
                    'status' => 2101,
                    'timeout' => Carbon::now()->modify('+30 days')->toDateTimeString()
                ]);
            } else {
                shareStatisticsModel::where([
                    'order_id' => $item->order_id,
                    'g_order_id' => $item->id,
                    'status' => 200,
                ])->update(['status' => 300, 'order_id' => $order_id]);
            }
            $item->status = 300;
            $item->order_id = $order_id;
            $item->save();
        } catch (Exception $e) {
            Log::info('子订单支付', [
                'time' => getTime(),
                'order_id' => $id,
                'info' => $e->getMessage()
            ]);
        }
    }
}
