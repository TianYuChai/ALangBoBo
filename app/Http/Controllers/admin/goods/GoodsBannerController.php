<?php
namespace App\Http\Controllers\admin\goods;

use App\Http\Controllers\admin\BaseController;
use Illuminate\Http\Request;

class GoodsBannerController extends BaseController
{
    const ROUTE = ADMIN_GOODS_CATEGORY; //视图路径

    public function index()
    {
        $data = [];
        return view(self::ROUTE. 'banner.index', compact('data'));
    }

    public function create()
    {
        return view(self::ROUTE. 'banner.create');
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
