<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/20
 * Time: 18:21
 */
namespace App\Http\Models\currency;

use Illuminate\Database\Eloquent\Model;

class MerchantBannerModel extends Model
{
    protected $table = 'merchant_banner';
    protected $guarded = ['id'];

    public static $_STATUS = [
        0 => '正常',
        1 => '下架'
    ];

    /*状态*/
    public function getStatusNameAttribute()
    {
        return array_get(self::$_STATUS, $this->status, '未知');
    }
}
