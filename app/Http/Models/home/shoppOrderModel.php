<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/30
 * Time: 11:27
 */
namespace App\Http\Models\home;

use App\Http\Models\currency\MerchantModel;
use Illuminate\Database\Eloquent\Model;

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
        700 => '订单取消'
    ];

    /*总订单*/
    public function order()
    {
        return $this->hasOne(orderModel::class, 'order_id', 'order_id');
    }
    /*商家*/
    public function merchant()
    {
        return $this->hasOne(MerchantModel::class, 'uid', 'gid');
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
}