<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/3
 * Time: 10:52
 */
namespace App\Http\Models\home;

use App\Http\Models\currency\MerchantModel;
use App\Http\Models\goods\goodsAttributeModel;
use App\Http\Models\goods\GoodsModel;
use Illuminate\Database\Eloquent\Model;

class shoppCarModel extends Model
{
    /*购物车*/
    protected $table = 'shopp_car';
    protected $guarded = ['id'];

    /*商品*/
    public function goods()
    {
        return $this->hasOne(GoodsModel::class, 'id', 'sid');
    }

    /*商家*/
    public function merchant()
    {
        return $this->hasOne(MerchantModel::class, 'uid', 'gid');
    }
    /**
     * 商品属性
     *
     * @return array
     */
    public function getGoodsAttributeAttribute()
    {
        if($this->attribute == 'null') {
            return [];
        }
        $attributes = json_decode($this->attribute);
        $result = [];
        $items = goodsAttributeModel::whereIn('id', $attributes)->get();
        foreach ($items as $item) {
            $result[] = [
                'id' => $item->id,
                'name' => $item->name,
                'value' => $item->value,
            ];
        }
        return $result;
    }
}
