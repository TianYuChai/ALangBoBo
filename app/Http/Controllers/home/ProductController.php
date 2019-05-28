<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/27
 * Time: 14:15
 */
namespace App\Http\Controllers\home;

use App\Http\Services\home\ProductService;
use Illuminate\Http\Request;

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
}
