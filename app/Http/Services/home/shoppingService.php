<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/5/29
 * Time: 20:45
 */
namespace App\Http\Services\home;
use App\Http\Models\admin\goods\goodsCategoryAttributeModel;
use App\Http\Models\currency\UserModel;
use App\Http\Models\goods\goodsAttributeModel;
use App\Http\Models\goods\GoodsModel;
use App\Http\Models\home\orderModel;
use App\Http\Models\home\shoppOrderModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Log;

class shoppingService extends BaseService
{
    public function __construct(GoodsModel $goodsModel,
                                goodsAttributeModel $goodsAttribute,
                                orderModel $orderModel,
                                shoppOrderModel $shoppOrderModel)
    {
         parent::__construct();
         $this->goods = $goodsModel;
         $this->goods_attribute = $goodsAttribute;
         $this->orderModel = $orderModel;
         $this->shopp_orderModel = $shoppOrderModel;
         $this->all_data = [
             'order_message' => [
                 'total_price' => 0,
                 'subscribed_price' => 0,
                 'paidin_price' => 0
             ],
         ];
    }

    public function buyNow($data)
    {
        if (is_array($data)) {
            $order_id = create_order_no();
            $ids = array_column($data,'id');
            $items = $this->goods::where('status', 0)->whereIn('id', $ids)->get();
            foreach ($data as $value) {
                $num = intval(trim($value['num']));
                $item = $items->where('id', $value['id'])->first();
                if(!$item) {
                    throw new Exception('商品信息错误, 请刷新重试');
                }
                if($item->uid == $this->user->id) {
                    throw new Exception('商家不可购买自己店铺的商品');
                }
                if($this->user->card == UserModel::where('id', $item->uid)->first()->card) {
                    throw new Exception('同类型账户不可购买');
                }
//                if($item->presell_time && $item->presell_time < getTime('ymd')) {
//                    throw new Exception($item->title. ', 该商品为预售商品, 并未到达售卖时间');
//                }
                if($num > $item->stocks) {
                    throw new Exception($item->title.', 该商品库存不足');
                }
                if(!empty($value['attribute'])) {
                    $attribute = $this->buyNowAttribute($value['id'], $value['attribute']);
                }
                $goods = [
                   'img' => $item->cost_img,
                   'title' => $item->title,
                   'attribute' => isset($attribute) ? $attribute : [],
                ];
                $money = $this->goodsPrice($item, $num);
                //先确认金额是否在可控之类，再去加入当前订单的金额中顺序不可乱
                $this->authBuyWay($value['pay_method'], $money['money']);
                $this->calculatePrice($value['pay_method'], $money['money']);
                //获取推荐人编码
                $referees_id = Redis::get('referess-'. $this->userId. '-'. $item->uid);
                $goods_orders[] = [
                    'uid' => $this->userId,
                    'gid' => $item->uid,
                    'sid' => $item->id,
                    'order_id' => $order_id,
                    'referees' => $referees_id,
                    'money' => $money['money'],
                    'num' => $num,
                    'fee' => $item->total_price,
                    'pay_method' => $value['pay_method'],
                    'goods' => json_encode($goods),
                    'delivery_fee' => $money['delivery_fee'],
                    'pack_mail' => $item->free_price,
                    'satisfied_fee' => $item->satic_price,
                    'sales_way' => isset($value['sales_way']) ? intval($value['sales_way']) : '',
                    'status' => 200
                ];
            }
            $this->createOrder($goods_orders);
            $order_id = $this->createTotalOrder($order_id);
            return $order_id;
        }
    }

    /**
     * 确认商品属性
     *
     * 在商品属性无异常的情况下，将商品属性返回
     *
     * @param $data
     * @throws Exception
     */
    protected function buyNowAttribute($id, $data)
    {
        try {
            $item = $this->goods_attribute::where('gid', intval($id))->whereIn('id', $data)->exists();
            if(!$item) {
                throw new Exception('存在不合法商品属性，请重新购买');
            }
            $res = $this->goods_attribute::where('gid', intval($id))->whereIn('id', $data)->get();
            return $res->map(function ($value, $key) {
                return [
                    'id' => $value->id,
                    'name' => $value->name,
                    'value' => $value->value,
                ];
            });
        } catch (Exception $e) {
            Log::info('下单流程->创建订单->属性过滤:', [
                'time' => getTime(),
                'goods_id' => $id,
                'user_id' => $this->user->id
            ]);
            throw new Exception($e->getMessage());
        }
    }

    /**
     * 判断订单模式
     *
     * 订单模式为，认缴
     *
     * 则去查询是否有认缴未付款的订单
     *
     * @param $data
     * @param $money
     * @throws Exception
     */
    protected function authBuyWay($data, $money)
    {
        try {
            if($data == 'subscribed') {
                $subscribed_money = intval(bcmul($this->user->frozen_capital, 10, 2));
                if($subscribed_money <= 0) {
                    throw new Exception('该购买方式下, 请先充值保证金');
                }
                $items = $this->shopp_orderModel::where('uid', $this->user->id)
                                                ->where('pay_method', $data)
                                                ->whereIn('status', [200, 300, 400, 500])
                                                ->where('timeout', '<>', '0000-00-00 00:00:00')->get();
                if(!$items->isEmpty()) {
                    $bought = bcdiv($items->pluck('money')->sum(), 100, 2);
                    if($bought >= $subscribed_money) {
                        throw new Exception('订单创建失败, 请先完
                                                    成认缴订单的缴纳, 也可取消当前订单中的认缴订单和充值更多的保证金');
                    }
                } else {
                    $bought = 0;
                }
                $subscribed_price = $this->all_data['order_message']['subscribed_price'];
                if($subscribed_price == 0) {
                    $subscribed_price = $money;
                }
                Log::info('认缴订单', [
                    'time' => getTime(),
                    '当前金额:' => $subscribed_money,
                    '已买金额:' => $items->pluck('money')->sum(),
                    '已买换算:' => bcdiv($items->pluck('money')->sum(), 100, 2),
                    '购买金额:' => $subscribed_price,
                    '剩余金额:' => $bought,
                    '当前认缴订单金额' => $this->all_data['order_message']['subscribed_price']
                ]);
                if($this->all_data['order_message']['subscribed_price'] > 0) {
                    if(bcadd($this->all_data['order_message']['subscribed_price'], $subscribed_price, 2) > bcsub($subscribed_money, $bought, 2)) {
                        throw new Exception('已超出保证金金额');
                    }
                }
                if($subscribed_price > bcsub($subscribed_money, $bought, 2)) {
                    throw new Exception('已超出保证金金额');
                }

            }
        } catch (Exception $e) {
            Log::info('下单流程->创建订单->验证订单支付模式:', [
                'time' => getTime(),
                'user_id' => $this->user->id,
                'info' => $e->getMessage()
            ]);
            throw new Exception($e->getMessage());
        }
    }

    /**
     * 计算商品是否包邮是否需要加入运费价格
     *
     * @param $data
     * @param $num
     * @return string
     * @throws Exception
     */
    protected function goodsPrice($data, $num)
    {
        try {
            $money = bcmul($data->total_price, $num, 2);
            $delivery_fee = 0;
            if($data->delivery_price != 0 && $money < $data->free_price) {
                $money = bcadd($money, $data->delivery_price, 2);
                $delivery_fee = $data->delivery_price;
            }
            return [
                'money' => $money,
                'delivery_fee' => $delivery_fee
            ];
        } catch (Exception $e) {
            Log::info('下单流程->创建订单->计算商品价格:', [
                'time' => getTime(),
                'user_id' => $this->user->id
            ]);
            throw new Exception($e->getMessage());
        }
    }

    /**
     * 计算订单价格
     *
     * 计算本次订单总价格，以及不同购买方式下的不同价格
     *
     * @param $pay_method
     * @param $money
     */
    protected function calculatePrice($pay_method, $money)
    {
        try {
            $this->all_data['order_message'] = [
                'total_price' => isset($this->all_data['order_message']['total_price']) ?
                    bcadd($this->all_data['order_message']['total_price'], $money,2) : $money,
                'subscribed_price' =>  $pay_method == 'subscribed' ?
                    isset($this->all_data['order_message']['subscribed_price']) ?
                        bcadd($this->all_data['order_message']['subscribed_price'], $money, 2) : $money : 0,
                'paidin_price' => $pay_method == 'paidin' ?
                    isset($this->all_data['order_message']['paidin_price']) ?
                        bcadd($this->all_data['order_message']['paidin_price'], $money,2) : $money : 0,
            ];
        } catch (Exception $e) {
            Log::info('下单流程->创建订单->计算价格:', [
                'time' => getTime(),
                'user_id' => $this->user->id,
                'money' => $money,
                'data' => $this->all_data
            ]);
            throw new Exception('请联系管理员');
        }
    }

    /**
     * 创建商品订单
     *
     * @param $data
     * @throws Exception
     */
    protected function createOrder($data)
    {
        DB::beginTransaction();
        try {
            foreach ($data as $datum) {
                $item = $this->goods::where('id', $datum['sid'])->sharedLock()->first();
                $item->sold = bcadd($datum['num'], $item->sold);
                $item->save();
                $this->shopp_orderModel::create($datum);
                DB::commit();
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('下单流程->创建订单->创建订单:', [
                'time' => getTime(),
                'user_id' => $this->user->id,
                'data' => $data
            ]);
            throw new Exception('请联系管理员');
        }
    }

    /**
     * 创建总订单
     *
     * @param $order_id
     * @return mixed
     * @throws Exception
     */
    protected function createTotalOrder($order_id)
    {
        DB::beginTransaction();
        try {
            $order = $this->orderModel::create([
                'uid' => $this->userId,
                'order_id' => $order_id,
                'total_price' => $this->all_data['order_message']['total_price'],
                'subscribed_price' => $this->all_data['order_message']['subscribed_price'],
                'paidin_price' => $this->all_data['order_message']['paidin_price'],
                'timeout'=> Carbon::now()->modify('+1 days')->toDateTimeString(),
                'status' => 2001
            ]);
            DB::commit();
            return $order->order_id;
        } catch (Exception $e) {
            DB::rollBack();
            $this->shopp_orderModel::where('order_id', $order_id)->delete();
            Log::info('下单流程->创建订单->创建总订单:', [
                'time' => getTime(),
                'user_id' => $this->user->id,
                'order_id' => $order_id
            ]);
            throw new Exception('请联系管理员');
        }
    }
}
