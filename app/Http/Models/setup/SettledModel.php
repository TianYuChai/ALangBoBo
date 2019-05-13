<?php

namespace App\Http\Models\setup;

use Illuminate\Database\Eloquent\Model;

class SettledModel extends Model
{
    /*设置-商家入驻费用表*/
    protected $table = "settled_in";
    protected $guarded = ['id'];
    /**
     * 访问器访问价格
     *
     * @return string|null
     */
    public function getMoneysAttribute()
    {
        return bcdiv($this->money, 100, 2);
    }

    /**
     * 修改器修改价格存储
     *
     * @param $value
     */
    public function setMoneyAttribute($value)
    {
        $this->attributes['money'] = bcmul($value, 100);
    }
}
