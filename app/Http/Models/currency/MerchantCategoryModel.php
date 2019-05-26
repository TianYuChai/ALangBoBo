<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/20
 * Time: 15:07
 */
namespace App\Http\Models\currency;

use Illuminate\Database\Eloquent\Model;

class MerchantCategoryModel extends Model
{
    protected $table = 'merchant_category';
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
