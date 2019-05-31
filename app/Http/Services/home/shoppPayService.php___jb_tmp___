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
use App\Http\Models\home\shareStatisticsModel;
use App\Http\Models\home\shoppOrderModel;
use Exception;
use Illuminate\Support\Facades\DB;
use Log;
use Yansongda\Pay\Pay;

class shoppPayService extends BaseService
{
    public function __construct(GoodsModel $goodsModel,
                                orderModel $orderModel,
                                shoppOrderModel $shoppOrderModel,
                                CapitalModel $capitalModel,
                                shareStatisticsModel $shareStatisticsModel)
    {
        parent::__construct();
        $this->goods = $goodsModel;
        $this->orderModel = $orderModel;
        $this->shopp_orderModel = $shoppOrderModel;
        $this->capitalModel = $capitalModel;
        $this->shareStatisticsModel = $shareStatisticsModel;
        $this->config = config('alipay.pay');
    }

    public function entrance($order_id, $data)
    {
        $this->merchantOrderAddressMemo($order_id, $data);
        $this->generateFlowSheet($order_id, $data);
        $item = $this->orderModel::where([
            'order_id' => $order_id,
            'status' => 2001
        ])->first();
        if($item->paidin_price == '0') {

        } else {
            if($data['method'] == 'Alipay') {
                return $this->alipay($item);
            } else if($data['method'] == 'WeChat'){

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
            if(!empty($data['memo'])) {
                $items = $this->shopp_orderModel::where('order_id', $order_id)->get();
                foreach ($data['memo'] as $datum) {
                    $item = $items->where('id', intval($datum['id']))->first();
                    $item->address = intval($data['address']);
                    $item->memo = $datum['val'];
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
            $capitai = [];
            $share = [];
            $items = $this->shopp_orderModel::where([
                'order_id' => $order_id,
                'pay_method' => 'paidin',
                'status' => 200
            ])->get();
            foreach ($items as $item) {
                $capitai[] = [
                    'uid' => $item->gid,
                    'order_id' => $item->order_id,
                    'money' => $item->moneys,
                    'trade_mode' => $data['method'],
                    'memo' => '用户备注:' . empty($item->memo) ? '无' : $item->memo. ','. '平台备注: 用户下单支付订单',
                    'category' => 500,
                    'status' => 1003,
                    'trans_at' => getTime(),
                    'created_at' => getTime(),
                    'updated_at' => getTime()
                ];
                if($item->referees) {
                    $share[] = [
                        'gid' => $item->gid,
                        'share_id' => $item->referees,
                        'order_id' => $item->order_id,
                        'status' => 200,
                        'created_at' => getTime(),
                        'updated_at' => getTime()
                    ];
                }
            }
            $this->capitalModel::insert($capitai);
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
     * 支付宝支付
     *
     * @param $data
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws Exception
     */
    protected function alipay($data)
    {
        try {
            $order = [
                'out_trade_no' => $data->order_id,
                'total_amount' => '0.02',
                'subject' => '阿郎博波商务中心',
                'body' => '商品购买',
            ];
            $this->config['notify_url'] = route('index.alipay.notify');
            $this->config['return_url'] = route('personal.creditmargin');
            $alipay = Pay::alipay($this->config)->web($order);
            return $alipay;
        } catch (Exception $e) {
            Log::info('订单支付：', [
                'time' => getTime(),
                'order_id' => $data->order_id,
                'info' => $e->getMessage()
            ]);
            throw new Exception('请联系管理员', 510);
        }
    }
}
