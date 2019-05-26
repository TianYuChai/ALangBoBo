<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/5/26
 * Time: 17:37
 */
namespace App\Http\Models\home;

use App\Http\Models\currency\UserModel;
use Illuminate\Database\Eloquent\Model;

class theBlackListModel extends Model
{
    protected $table = 'theblacklist';
    protected $guarded = ['id'];

    public static $_TYPE = [
        0 => '商家',
        1 => '用户'
    ];
    public static $_STATUS = [
        0 => '申请',
        1 => '已处理'
    ];
    public function user()
    {
        return $this->hasOne(UserModel::class, 'id', 'gid');
    }
    /**
     * 被举报人
     *
     * @return mixed
     */
    public function getGnameAttribute()
    {
        return UserModel::where('id', $this->gid)->value('account');
    }

    /**
     * 举报人
     *
     * @return mixed
     */
    public function getUserNameAttribute()
    {
        return UserModel::where('id', $this->uid)->value('account');
    }

    /**
     * 类型
     *
     * @return mixed
     */
    public function getTypeNameAttribute()
    {
        return array_get(self::$_TYPE, $this->type, '未知');
    }

    /**
     * 状态
     *
     * @return mixed
     */
    public function getStatusNameAttribute()
    {
        return array_get(self::$_STATUS, $this->status, '未知');
    }
}