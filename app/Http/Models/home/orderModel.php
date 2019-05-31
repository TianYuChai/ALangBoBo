<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/30
 * Time: 11:24
 */
namespace App\Http\Models\home;

use function foo\func;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Log;

class orderModel extends Model
{
    protected $table = 'orders';
    protected $guarded = ['id'];

    public static $_STATUS = [
        2001 => '订单创建',
        2101 => '完成支付',
    ];

    public function child()
    {
        return $this->hasMany(shoppOrderModel::class, 'order_id', 'order_id');
    }
    /*总价*/
    public function setTotalPriceAttribute($value)
    {
        $this->attributes['total_price'] = bcmul($value, 100);
    }
    /*认缴价*/
    public function setSubscribedPriceAttribute($value)
    {
        $this->attributes['subscribed_price'] = bcmul($value, 100);
    }
    /*实缴价*/
    public function setPaidinPriceAttribute($value)
    {
        $this->attributes['paidin_price'] = bcmul($value, 100);
    }

    /*换算总价*/
    public function getTotalPricesAttribute()
    {
        return bcdiv($this->total_price, 100, 2);
    }
    /*换算认缴价*/
    public function getSubscribedPricesAttribute()
    {
        return bcdiv($this->subscribed_price, 100, 2);
    }
    /*换算实缴价*/
    public function getPaidinPricesAttribute()
    {
        return bcdiv($this->paidin_price, 100, 2);
    }
    /**
     * 事件处理
     * created: 在创建总订单时创建分享数据
     */
    protected static function boot()
    {
        parent::boot();
        /*创建分享数据*/
        static::created(function ($query) {
            foreach ($query->child as $item) {
                try {
                    if($item->referees) {
                        shareStatisticsModel::create([
                            'gid' => $item->gid,
                            'share_id' => $item->referees,
                            'order_id' => $item->order_id,
                            'status' => $item->status
                        ]);
                    }
                } catch (Exception $e) {
                    Log::info('创建推荐人分享数据: ', [
                        'order_id' => $item->order_id,
                        'time' => getTime(),
                        'id' => $item->id,
                        'info' => $e->getMessage()
                    ]);
                }
            }
        });
    }

    /**
     * 把同一个订单下面相同的订单进行组合
     *
     * @return array
     */
    public function getOrdersAttribute()
    {
        $result = [];
        foreach ($this->child as $item) {
            if(isset($result[$item->gid])) {
                $result[$item->gid]['data'][] = $item;
            } else {
                $result[$item->gid] = [
                    'name' => $item->merchant->shop_name,
                    'code' => $item->merchant->code,
                    'data' => [$item]
                ];
            }
        }
        return array_values($result);
    }

    /**
     * 订单总运费
     *
     * @return string
     */
    public function getDeliveryFeeAttribute()
    {
        $result = 0;
        foreach ($this->child() as $item) {
            $result += $item->deliver_price;
        }
        $delivery_price = bcdiv($result, 100, 2);
        return $delivery_price == '' ? 0 : $delivery_price;
    }
}
