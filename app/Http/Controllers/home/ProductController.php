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
        $category_id = $request->category;

        $categorys = $service->entrance($type, $category_id);

        return view('home.product');
    }
}
