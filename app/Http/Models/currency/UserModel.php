<?php

namespace App\Http\Models\currency;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $guarded  = ['id'];

    /**
     * 账户类别
     * @var array
     */
    public static $_CATEGORY = [
        0 => '买家',
        1 => '企业',
        2 => '个人'
    ];

    /**
     * 账户状态
     * @var array
     */
    public static $_STATUS = [
        0 => '待审核',
        1 => '正常',
        2 => '封停',
        3 => '注销'
    ];

    /**
     * 账户类别展示
     * @return mixed
     */
    public function getCategoryNameAttribute()
    {
        return array_get(self::$_CATEGORY, $this->category, '未知');
    }

    /**
     * 账户状态展示
     * @return mixed
     */
    public function getStatusNameAttribute()
    {
        return array_get(self::$_STATUS, $this->status, '未知');
    }
}
