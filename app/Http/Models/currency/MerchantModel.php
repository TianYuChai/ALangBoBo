<?php

namespace App\Http\Models\currency;

use App\Http\Models\admin\goods\goodsCategoryModel;
use App\Http\Models\home\orderModel;
use App\Http\Models\home\shoppOrderModel;
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

    /*用户*/
    public function user()
    {
        return $this->hasOne(UserModel::class, 'id', 'uid');
    }
    public function order()
    {
        return $this->hasMany(shoppOrderModel::class, 'gid', 'uid');
    }
    /*店铺分类*/
    public function categorys()
    {
        return $this->hasMany(MerchantCategoryModel::class, 'uid', 'uid')
                        ->orderBy('sort', 'desc');
    }
    /*店铺轮播*/
    public function img()
    {
        return $this->hasMany(MerchantBannerModel::class, 'uid', 'uid')
                        ->orderBy('sort', 'desc');
    }
    /**
     * 店铺类别
     *
     * @return mixed
     */
    public function getDistNameAttribute()
    {
        return array_get(self::$_DISTINGUISH, $this->distinguish, '未知');
    }

    /**
     * 搜索账户
     *
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearchName($query, $search)
    {
        if(!empty($search)) {
            $user_ids = UserModel::where('account', 'like', "%{$search}%")->get(['id'])->toArray();
            return $query->whereIn('uid', $user_ids);
        }
    }

    /**
     * 搜索商品名称
     *
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearchShopName($query, $search)
    {
        if(!empty($search)) {
            return $query->where('shop_name', 'like', "{$search}");
        }
    }
}
