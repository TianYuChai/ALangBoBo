<?php

namespace App\Http\Models\currency;

use App\Http\Models\admin\RegisterAuditingModel;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{
    /*用户表*/
    protected $table = 'users';
    protected $guarded  = ['id'];

    /**
     * 改写
     * @var string
     */
    protected $rememberTokenName = '';
    protected $hidden = [   //在模型数组或 JSON 显示中隐藏某些属性
        'password'
    ];

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
     * 商户关联表
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function merchant()
    {
        return $this->hasOne(MerchantModel::class, 'uid', 'id');
    }

    public function registerauditing()
    {
        return $this->hasOne(RegisterAuditingModel::class, 'uid', 'id');
    }

    public function capital()
    {
        return $this->hasMany(CapitalModel::class, 'uid', 'id');
    }
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

    /**
     * 搜索时间
     *
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearchTime($query, $search)
    {
       if(!empty($search)) {
            $time_section = explode(' - ', $search);
            return $query->whereBetween('created_at', $time_section);
       }
    }

    /**
     * 搜索账户名
     *
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearchAccount($query, $search)
    {
        if(!empty($search)) {
            return $query->where('account', 'like', "%{$search}%");
        }
    }

    /**
     * 搜索类别
     *
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearchCategory($query, $search)
    {
        if(!empty($search) || $search == "0") {
            return $query->where('category', intval($search));
        }
    }

    /**
     * 搜索状态
     *
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearchStatus($query, $search)
    {
        if(!empty($search) || $search == "0") {
            return $query->where('status', intval($search));
        }
    }

    /**
     * 查询当前用户信用保证金冻结金额
     *
     * @return mixed
     */
    public function getFrozenCapitalAttribute()
    {
        return $this->capital()->where([
            'category' => 300,
            'status' => 1003
        ])->sum('money');
    }

    /**
     * 可用金额
     *
     * @return mixed
     */
    public function getAvailableMoneyAttribute()
    {
        return $this->capital()->where(function ($query) {
                $query->whereIn('category', [100, 300, 500])->where('status', 1001);
        })->sum('money');
    }
}
