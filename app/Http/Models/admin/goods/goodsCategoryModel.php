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
}