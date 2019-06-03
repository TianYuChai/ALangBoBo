<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/27
 * Time: 14:15
 */
namespace App\Http\Controllers\home;

use App\Http\Models\goods\GoodsModel;
use App\Http\Services\home\ProductService;
use Illuminate\Http\Request;
use Exception;

class ProductController extends BaseController
{
    public function index($type, Request $request, ProductService $service)
    {
        $min_price = $request->min_price;
        $max_price = $request->max_price;
        $category_goodss = $service->entrance($type, [
            'min_price' => $min_price,
            'max_price' => $max_price
        ]);
        return view('home.product', compact('category_goodss'));
    }

    /**
     * 数据展示
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $item = GoodsModel::where([
            'id' => intval($id),
            'status' => 0,
        ])->first();
        $recom_goods = GoodsModel::where('id', '<>', intval($id))->where([
            'status' => 0,
            'recom' => 1,
            'uid' => $item->uid
        ])->get();
        return view('home.show', compact('item', 'recom_goods'));
    }
}
