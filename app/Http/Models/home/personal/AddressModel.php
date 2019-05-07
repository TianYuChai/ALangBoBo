<?php

namespace App\Http\Models\home\personal;

use Illuminate\Database\Eloquent\Model;

class AddressModel extends Model
{
    /*地址表*/
    protected $table = 'address';

    /**
     * 地址类别
     *
     * @var array
     */
    public static $_CATEGORY = [
        800 => '收货地址',
        900 => '发货地址'
    ];

    /**
     * 地址状态
     *
     * @var array
     */
    public static $_STATUS = [
        600 => '普通地址',
        700 => '默认发货地址',
        701 => '默认退货地址',
        702 => '默认收货地址',
        703 => '默认发退货地址'
    ];

    /**
     * 是否为收货地址
     *
     * @return bool
     */
    public function getWhetherReceAddressAttribute()
    {
        return $this->status == 702 ? true : false;
    }

    /**
     * 是否为发货地址
     *
     * @return bool
     */
    public function getWhetherDeliveryAddressAttribute()
    {
        return $this->status == 700 ? true : false;
    }

    /**
     * 是否为退货地址
     *
     * @return bool
     */
    public function getWhetherReturnAddressAttribute()
    {
        return $this->status == 701 ? true : false;
    }

    /**
     * 是否为发退货地址
     *
     * @return bool
     */
    public function getWhetherRetreatAddressAttribute()
    {
        return $this->status == 703 ? true : false;
    }
}
