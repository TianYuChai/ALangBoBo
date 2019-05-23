<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/23
 * Time: 10:13
 */
namespace App\Http\Models\goods;

use Illuminate\Database\Eloquent\Model;

class goodsImgModel extends Model
{
    /*商品图片表*/
    protected $table = 'goods_imgs';
    protected $guarded = ['id'];
}
