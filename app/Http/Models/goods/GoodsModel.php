<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/23
 * Time: 10:10
 */
namespace App\Http\Models\goods;

use Illuminate\Database\Eloquent\Model;

class GoodsModel extends Model
{
    /*商品表*/
    protected $table = 'goods';
    protected $guarded = ['id'];

    public static $_STATUS = [
        0 => '出售',
        1 => '下架'
    ];
    /*商品属性*/
    public function attribute()
    {
        return $this->hasMany(goodsAttributeModel::class, 'gid', 'id');
    }

    /*商品图片*/
    public function img()
    {
        return $this->hasMany(goodsImgModel::class, 'gid', 'id');
    }

    /*总价*/
    public function setTotalFeeAttribute($value)
    {
        $this->attributes['total_fee'] = bcmul($value, 100);
    }
    /*成本*/
    public function setCostFeeAttribute($value)
    {
        $this->attributes['cost_fee'] = bcmul($value, 100);
    }
    /*满意度*/
    public function setSaticFeeAttribute($value)
    {
        $this->attributes['satic_fee'] = bcmul($value, 100);
    }
    /*运费*/
    public function setDeliveryFeeAttribute($value)
    {
        if($value) {
            $this->attributes['delivery_fee'] = bcmul($value, 100);
        }
    }
    /*包邮*/
    public function setFreeFeeAttribute($value)
    {
        if($value) {
            $this->attributes['free_fee'] = bcmul($value, 100);
        }
    }
    /*展示封面图*/
    public function getCostImgAttribute()
    {
        return $this->img()->where('type', 1)->first()->img;
    }
    /*展示轮播图*/
    public function getShuffImgAttribute()
    {
        return $this->img()->where('type', 2)->get();
    }
    /*换算总价*/
    public function getTotalPriceAttribute()
    {
        return bcdiv($this->total_fee, 100, 2);
    }
    /*换算成本*/
    public function getCostPriceAttribute()
    {
        return bcdiv($this->cost_fee, 100, 2);
    }
    /*换算满意度*/
    public function getSaticPriceAttribute()
    {
        return bcdiv($this->satic_fee, 100, 2);
    }
    /*换算运费*/
    public function getDeliveryPriceAttribute()
    {
        if($this->delivery_fee) {
            return bcdiv($this->delivery_fee, 100, 2);
        }
    }
    /*换算包邮*/
    public function getFreePriceAttribute()
    {
        if($this->free_fee) {
            return bcdiv($this->free_fee, 100, 2);
        }
    }

    /*商品状态*/
    public function getStatusNameAttribute()
    {
        return array_get(self::$_STATUS, $this->status, '未知');
    }

    /*商品属性*/
    public function getAttributesAttribute()
    {
        if(!$this->attribute->isEmpty()) {
            $attributes = [];
            foreach ($this->attribute as $item) {
                $attributes[$item->name][] = [
                    'id' => $item->id,
                    'value' => $item->value
                ];
            }
            return $attributes;
        }
    }
    public function getStocksAttribute()
    {
        return bcsub($this->stock, $this->sold);
    }
    /**
     * 搜索商品标题
     *
     * @param $query
     * @param $value
     * @return mixed
     */
    public function scopeSearchTitle($query, $value)
    {
        if(!empty($value)) {
            return $query->where('title', 'like', "%{$value}%");
        }
    }
}
