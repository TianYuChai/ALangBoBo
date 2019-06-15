<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/14
 * Time: 14:56
 */
namespace App\Http\Models\home;

use App\Http\Models\currency\UserModel;
use Illuminate\Database\Eloquent\Model;

class demandModel extends Model
{
    public function user()
    {
        return $this->hasOne(UserModel::class, 'id', 'uid');
    }
    public function guser()
    {
        return $this->hasOne(UserModel::class, 'id', 'gid');
    }
    /*需求表*/
    protected $table = 'demand';
    protected $guarded = ['id'];

    //展示方式
    public static $_DISPLAY = [
        101 => '画',
        102 => '歌词和乐谱',
        103 => '动漫视频',
        104 => '户外活动',
        105 => '其他'
    ];

    //材料选择
    public static $_MATERIAL = [
        201 => '纸',
        202 => '布',
        203 => '油画',
        204 => '水粉',
        205 => '水墨',
        206 => '木头',
        207 => '石头',
        208 => '其他'
    ];

    //状态
    public static $_STATUS = [
        301 => '取消',
        302 => '待支付',
        303 => '可接单',
        304 => '已接单',
        305 => '确认',
        306 => '完成',
        307 => '退款中',
        308 => '已退款'
    ];

    public function getMoneysAttribute()
    {
        return bcdiv($this->money, 100, 2);
    }

    public function getStatusNameAttribute()
    {
        return array_get(self::$_STATUS, $this->status, '未知');
    }

    public function scopeSearchStatus($query, $search)
    {
        if(!empty($search)) {
            return $this->where('status', intval($search));
        }
    }

    public function scopeSearchTitle($query, $search)
    {
        if(!empty($search)) {
            return $query->where('title', 'like', "%{$search}%");
        }
    }

    public function scopeSearchAccount($query, $search)
    {
        if(!empty($search)) {
            $user_ids = UserModel::where('account', 'like', "%{$search}%")->get()->pluck('id')->toArray();
            return $query->whereIn('uid', $user_ids);
        }
    }
    public function getCostPriceAttribute()
    {
        return bcdiv($this->cost, 100, 2);
    }

    public function getSatisfactionPriceAttribute()
    {
        return bcdiv($this->satisfaction, 100, 2);
    }

    public function getPoundagePriceAttribute()
    {
        return bcdiv($this->poundage, 100, 2);
    }
}
