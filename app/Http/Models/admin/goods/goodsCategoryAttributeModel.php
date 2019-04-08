<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/4/8
 * Time: 21:47
 */
namespace App\Http\Models\admin\goods;
use Illuminate\Database\Eloquent\Model;

class goodsCategoryAttributeModel extends Model
{
    /*商品分类属性表*/
    protected $table = 'goods_category_attribute';
    protected $guarded = ['id'];
}