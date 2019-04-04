<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/4
 * Time: 9:33
 */
namespace App\Http\Controllers\admin\goods;

use App\Http\Controllers\admin\BaseController;

class GoodsCategoryController extends BaseController
{
    const ROUTE = ADMIN_GOODS_CATEGORY; //视图路径

    public function index()
    {
        return view(self::ROUTE. 'index');
    }

    public function create()
    {
        return view(self::ROUTE. 'create');
    }
}
