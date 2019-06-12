<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/12
 * Time: 9:18
 */
namespace App\Http\Controllers\home;

use App\Http\Models\admin\goods\goodsCategoryModel;
use App\Http\Models\home\partTimeModel;
use Illuminate\Support\Facades\Input;

class parTimeListController extends BaseController
{
    public function __construct(partTimeModel $model,goodsCategoryModel $categoryModel)
    {
        $this->model = $model;
        $this->categoryModel = $categoryModel;
    }

    public function index()
    {
        $search_category = Input::get('category', '');
        $search_settle = Input::get('settle', '');
        $search_min_price = trim(Input::get('min_price', ''));
        $search_max_price = trim(Input::get('max_price', ''));
        $items = $this->model::SearchCategory($search_category)
                                ->SearchSettle($search_settle)
                                ->SearchPrice([$search_min_price, $search_max_price])->paginate(20);
        $categorys = $this->categoryModel::where([
            'status' => 0,
            'p_id' => 19
        ])->get();
        $settles = partTimeModel::$_SETTLE;
        return view('home.part_time_list', compact('items', 'categorys', 'settles'));
    }
}
