<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/30
 * Time: 11:27
 */
namespace App\Http\Models\home;

use App\Http\Models\currency\CapitalModel;
use App\Http\Models\currency\MerchantModel;
use App\Http\Models\currency\UserModel;
use App\Http\Models\goods\GoodsModel;
use App\Http\Models\setup\complainModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Support\Facades\Auth;
use Log;
use Illuminate\Support\Facades\DB;

class shoppOrderModel extends Model
{
    protected $table = 'shopp_orders';
    protected $guarded = ['id'];

    public static $_STATUS = [
        100 => '订单取消',
        200 => '订单待支付',
        300 => '完成支付',
        400 => '商家发货',
        500 => '用户签收',
        600 => '订单完成',
        700 => '已申请退款',
        800 => '退款中',
        900 => '完成退款'
    ];

    /**
     * 事件处理
     * created: 在创建总订单时创建分享数据
     */
    protected static function boot()
    {
        parent::boot();
        /*更新订单对应数据，子订单状态以及分享订单状态*/
        static::updated(function ($query) {
            try {
                if(isset($query->getDirty()['status'])) {
                    $status = $query->getDirty()['status'];
                    shareStatisticsModel::where([
                        'order_id' => $query->order_id,
                        'g_order_id' => $query->id,
                    ])->update(['status' => $query->getDirty()['status']]);
                    if($status == 500 && ($query->timeout =='0000-00-00 00:00:00' || $query->timeout == '')) {
                        CapitalModel::create([
                            'uid' => $query->gid,
                            'order_id' => $query->order_id,
                            'g_order_id' => $query->id,
                            'money' => bcsub($query->moneys, $query->satisfiedfees, 2),
                            'trade_mode' => isset($query->order->pay_method) ? $query->order->pay_method : 'Alipay',
                            'memo' => '用户备注:' . empty($query->memo) ? '无, 平台备注: 用户下单支付订单' :
                                                $query->memo. ','. '平台备注: 用户下单支付订单',
                            'category' => 500,
                            'status' => 1001,
                            'trans_at' => $query->created_at,
                        ]);
                    }
                    if(in_array($status, [100, 900])) {
                        /*取消订单同时, 撤回对应流水以及商品库存*/
                        DB::beginTransaction();
                        try {
//                            CapitalModel::where([
//                                'order_id' => $query->order_id,
//                                'g_order_id' => $query->id,
//                                'category' => 500,
//                                'status' => 1003
//                            ])->update(['status' => 1002]);
                            $item = GoodsModel::where('id', $query->sid)->sharedLock()->first();
                            $item->sold = bcsub($item->sold, $query->num);
                            $item->save();
                            /*退款*/
                            if($query->getDirty()['status'] == 900) {
                                $order = orderModel::where('order_id', $query->order_id)->first();
                                $order->refund = bcadd($order->refund, $query->money);
                                $order->save();
                            }
                            DB::commit();
                        } catch (Exception $e) {
                            DB::rollBack();
                        }
                    }
                }
            } catch (Exception $e) {
                Log::info('支付完成后，更新对应数据: ', [
                    'order_id' => $query->order_id,
                    'id' => $query->id,
                    'time' => getTime(),
                    'info' => $e->getMessage()
                ]);
            }
        });
    }
    public static $_METHOD = [
        'subscribed' => '认缴',
        'paidin' => '实缴'
    ];
    /*总订单*/
    public function order()
    {
        return $this->hasOne(orderModel::class, 'order_id', 'order_id');
    }
    /*用户*/
    public function user()
    {
        return $this->hasOne(UserModel::class, 'id', 'uid');
    }
    /*商家*/
    public function merchant()
    {
        return $this->hasOne(MerchantModel::class, 'uid', 'gid');
    }
    /*投诉与建议*/
    public function getComplainAttribute()
    {
        $items = complainModel::where('g_order_id', $this->id)->get();
        if($items->isEmpty()) {
            return false;
        }

        foreach ($items as $item) {
            if($item->uid == Auth::guard('web')->user()->id) {
                return true;
            }
        }
    }
    public function getComplainTextAttribute()
    {
        if($this->complain) {
            return complainModel::where([
                'uid' => Auth::guard('web')->user()->id,
                'g_order_id' => $this->id
            ])->first();
        }
    }
    /*商品评价*/
    public function evaluation()
    {
        return $this->hasOne(evaluationModel::class, 'order_id', 'id');
    }
    /*总价*/
    public function setMoneyAttribute($value)
    {
        $this->attributes['money'] = bcmul($value, 100);
    }
    /*满意度*/
    public function setSatisfiedFeeAttribute($value)
    {
        $this->attributes['satisfied_fee'] = bcmul($value, 100);
    }
    /*运费*/
    public function setDeliveryFeeAttribute($value)
    {
        if($value) {
            $this->attributes['delivery_fee'] = bcmul($value, 100);
        }
    }
    /*包邮*/
    public function setPackMailAttribute($value)
    {
        if($value) {
            $this->attributes['pack_mail'] = bcmul($value, 100);
        }
    }
    /*单价*/
    public function setFeeAttribute($value)
    {
        $this->attributes['fee'] = bcmul($value, 100);
    }

    /*换算总价*/
    public function getMoneysAttribute()
    {
       return bcdiv($this->money, 100,2);
    }
    /*满意度*/
    public function getSatisfiedFeesAttribute()
    {
        return bcdiv($this->satisfied_fee, 100, 2);
    }
    /*运费*/
    public function getDeliveryFeesAttribute()
    {
        return bcdiv($this->delivery_fee, 100, 2);
    }
    /*包邮*/
    public function getFreePriceAttribute()
    {
        return bcdiv($this->pack_mail, 100, 2);
    }
    /*单价*/
    public function getFeesAttribute()
    {
        return bcdiv($this->fee, 100, 2);
    }

    /**
     * 格式化商品属性
     *
     * @return mixed
     */
    public function getGoodssAttribute()
    {
        return json_decode($this->goods);
    }

    /**
     * 格式化收货地址
     *
     * @return mixed
     */
    public function getAddresssAttribute()
    {
        return json_decode($this->address);
    }
    /**
     * 支付方式
     *
     * @return mixed
     */
    public function getPayMethodsAttribute()
    {
        return array_get(self::$_METHOD, $this->pay_method, '未知');
    }

    /**
     * 状态
     *
     * @return mixed
     */
    public function getStatusNameAttribute()
    {
        return array_get(self::$_STATUS, $this->status, '未知');
    }

    /**
     * 搜索订单
     *
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearchOrderId($query, $search)
    {
        if(!empty($search)) {
            return $query->where('order_id', 'like', "%{$search}%");
        }
    }

    /**
     * 状态搜索
     *
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearchStatus($query, $search)
    {
        if(!empty($search)) {
            return $query->where('status', $search);
        }
    }

    /**
     * 自动签收倒计时
     *
     * @return string
     */
    public function getSignCountdowAttribute()
    {
        Carbon::setLocale('zh');
        $now = Carbon::now();
        $time = Carbon::parse($this->signtime);
        $difference = ($time->diff($now)->days < 1)
            ? 'today'
            : $time->diffForHumans($now);
        return $difference;
    }

    /**
     * 认缴签收倒计时
     *
     * @return string
     */
    public function getSettleSubscribedAttribute()
    {
        if($this->pay_method == 'subscribed') {
            Carbon::setLocale('zh');
            $now = Carbon::now();
            $time = Carbon::parse($this->timeout);
            $difference = ($time->diff($now)->days < 1)
                ? 'today'
                : $time->diffForHumans($now);
            return $difference;
        }
    }
}
