<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/8
 * Time: 14:29
 */
namespace App\Http\Models\admin\goods;

use Illuminate\Database\Eloquent\Model;

class goodsCategoryModel extends Model
{
    /*商品分类表*/
    protected $table = 'goods_category';
    protected $guarded = ['id'];

    public static $_STATUS = [
        0 => '已启用',
        1 => '已下架'
    ];

    public function getStatusNameAttribute()
    {
        return array_get(self::$_STATUS, $this->status, '未知');
    }

    public function attribute()
    {
        return $this->hasMany(goodsCategoryAttributeModel::class, 'cate_id', 'id')->where('status', 0);
    }

    /**
     * 获取名称
     *
     * @return mixed|string
     */
    public function getParentMessageAttribute()
    {
        if($this->level == 1) {
            return $this->cate_name;
        } else {
            $parent = $this->where('id', $this->p_id)->first();
            $parents = $this->where('id', $parent->p_id)->first();
            return $parents->cate_name .'/'. $parent->cate_name;
        }
    }
}
