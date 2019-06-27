<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/27
 * Time: 10:38
 */
namespace App\Http\Models\setup;

use App\Http\Models\currency\UserModel;
use Illuminate\Database\Eloquent\Model;

class complainModel extends Model
{
    protected $table = 'complain';
    protected $guarded = ['id'];

    public static $_STATUS = [
        0 => '公示',
        1 => '不公式'
    ];
    public static $_NAME = [
        0 => '用户',
        1 => '商家'
    ];

    public function getStatusNameAttribute()
    {
        if(empty($this->status) && $this->status != '0') {
            return '未处理';
        }
        return array_get(static::$_STATUS, $this->status, '未处理');
    }

    public function getNamesAttribute()
    {
        return array_get(static::$_NAME, $this->name, '未知');
    }
    public function user()
    {
        return $this->hasOne(UserModel::class, 'id', 'uid');
    }

    public function buser()
    {
        return $this->hasOne(UserModel::class, 'id', 'gid');
    }

    public function scopeSearchStatus($query, $search)
    {
        if(!empty($search) || $search == '0') {
            return $query->where('status', intval($search));
        }
    }
}
