<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/30
 * Time: 11:27
 */
namespace App\Http\Models\home;

use Illuminate\Database\Eloquent\Model;

class shoppOrderModel extends Model
{
    protected $table = 'shopp_orders';
    protected $guarded = ['id'];

    public static $_STATUS = [
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
}
