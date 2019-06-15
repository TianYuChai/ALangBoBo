<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/6/15
 * Time: 23:01
 */
namespace App\Http\Models\setup;

use Illuminate\Database\Eloquent\Model;

class shoppDuiteModel extends Model
{
    /*购物指南表*/
    protected $table = 'shopp_duite';
    protected $guarded = ['id'];

    public static $_CATEGORY = [
        1 => '导购演示',
        2 => '常见问题',
        3 => '商家入驻',
        4 => '培训中心',
        5 => '商家帮助',
        6 => '服务市场',
        7 => '规则中心'
    ];
}