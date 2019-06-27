<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/27
 * Time: 10:38
 */
namespace App\Http\Models\setup;

use Illuminate\Database\Eloquent\Model;

class complainModel extends Model
{
    protected $table = 'complain';
    protected $guarded = ['id'];

    public static $_STATUS = [
        0 => '是',
        1 => '否'
    ];

    public function getStatusNameAttribute()
    {
        return array_get(static::$_STATUS, $this->status, '未处理');
    }
}
