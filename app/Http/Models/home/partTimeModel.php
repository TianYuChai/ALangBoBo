<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/11
 * Time: 16:25
 */
namespace App\Http\Models\home;

use App\Http\Models\admin\goods\goodsCategoryModel;
use App\Http\Models\currency\MerchantModel;
use App\Http\Models\currency\UserModel;
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

    public function merchant()
    {
        return $this->hasOne(MerchantModel::class, 'uid', 'uid');
    }

    public function send()
    {
        return $this->hasMany(partTimeSendModel::class, 'pid', 'id');
    }
    public function getMoneysAttribute()
    {
        return bcdiv($this->money, 100, 2);
    }

    public function getSettlesAttribute()
    {
        return array_get(self::$_SETTLE, $this->settle, '未知');
    }

    /**
     * 分类筛选
     *
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearchCategory($query, $search)
    {
        if(!empty($search)) {
            return $query->where('category_id', intval($search));
        }
    }

    /**
     * 结算方式
     *
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearchSettle($query, $search)
    {
        if(!empty($search)) {
            return $query->where('settle', intval($search));
        }
    }

    /**
     * 薪资搜索
     *
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearchPrice($query, $search)
    {
        if(!empty($search[0]) && !empty($search[1])) {
            $price[] = bcmul($search[0], 100);
            $price[] = bcmul($search[1], 100);
            return $query->whereBetween('money', $price);
        }
    }

    public function getCategoryNameAttribute()
    {
        return goodsCategoryModel::where('id', $this->category_id)->value('cate_name');
    }

    public function scopeSearchAccout($query, $search)
    {
        if(!empty($search)) {
            $user_ids = UserModel::where('account', 'like', "%{$search}%")->where('status', 0)->get()->pluck('id')->toArray();
            return $query->whereIn('uid', $user_ids);
        }
    }
}
