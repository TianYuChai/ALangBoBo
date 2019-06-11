<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/11
 * Time: 16:25
 */
namespace App\Http\Models\home;

use Illuminate\Database\Eloquent\Model;

class partTimeModel extends Model
{
    protected $table = 'part_time';
    protected $guarded = ['id'];

    public static $_SETTLE = [
        12 => '月',
        13 => '天',
        14 => '小时'
    ];

    public function getMoneysAttribute()
    {
        return bcdiv($this->money, 100, 2);
    }

    public function getSettlesAttribute()
    {
        return array_get(self::$_SETTLE, $this->settle, '未知');
    }
}
