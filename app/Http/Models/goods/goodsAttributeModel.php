<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/23
 * Time: 10:11
 */
namespace App\Http\Models\goods;

use Illuminate\Database\Eloquent\Model;

class goodsAttributeModel extends Model
{
    /*商品属性表*/
    protected $table = 'goods_attribute';
    protected $guarded = ['id'];
}
