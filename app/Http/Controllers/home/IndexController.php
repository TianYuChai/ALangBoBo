<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/15
 * Time: 14:29
 */
namespace App\Http\Controllers\home;

use App\Http\Models\setup\shoppDuiteModel;
use App\Http\Services\home\IndexService;

class IndexController extends BaseController
{
    public function index(IndexService $indexService)
    {
        $data = $indexService->entrance();
        return view('home.index', compact('data'));
    }

    public function button($id)
    {
        $item = shoppDuiteModel::where('category_id', intval($id))->first();
        return view('home.index_button', compact('item'));
    }
}
