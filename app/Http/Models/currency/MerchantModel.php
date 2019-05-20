<?php

namespace App\Http\Models\currency;

use Illuminate\Database\Eloquent\Model;

class MerchantModel extends Model
{
    /*商户表*/
    protected $table = 'merchant';
    protected $guarded = ['id'];

    public static $_DISTINGUISH = [
        0 => '普通商户',
        1 => '加盟店',
        2 => '直营店'
    ];

    public function getDistNameAttribute()
    {
        return array_get(self::$_DISTINGUISH, $this->distinguish, '未知');
    }
}
