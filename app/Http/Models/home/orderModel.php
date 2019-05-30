<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/30
 * Time: 11:24
 */
namespace App\Http\Models\home;

use Illuminate\Database\Eloquent\Model;

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
}
