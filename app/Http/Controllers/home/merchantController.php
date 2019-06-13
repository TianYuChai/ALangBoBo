<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/13
 * Time: 14:28
 */
namespace App\Http\Controllers\home;

use App\Http\Models\admin\goods\goodsCategoryModel;
use App\Http\Models\currency\MerchantCategoryModel;
use App\Http\Models\currency\MerchantModel;
use App\Http\Models\goods\GoodsModel;
use App\Http\Models\home\shareModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis;

class merchantController extends BaseController
{
    public function index()
    {
        $items = MerchantModel::where('distinguish', '!=', 0)
                                        ->where('status', 1)->paginate(40);
        return view('home.merchant', compact('items'));
    }

    /**
     * 展示数据
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $item = MerchantModel::where('id', intval($id))->first();
        if(Auth::guard('web')->check()) {
            $referees_id = Input::get('referess', '');
            if(!empty($referees_id)) {
                if(shareModel::where('share_id', $referees_id)->exists()) {
                    $uid = Auth::guard('web')->user()->id;
                    //存入推荐人id
                    Redis::set('referess-'. $uid. '-'. $item->uid, $referees_id);
                }
            }
        }
        $goods = GoodsModel::where([
            'status' => 0,
            'uid' => $item->uid
        ])->orderBy('id', 'desc')->get();
        return view('home.merchant_show', compact('item', 'goods'));
    }

    public function evenMore($id)
    {
        $keyword = trim(Input::get('keyword', ''));
        $category = Input::get("category", '');
        $min_price = trim(Input::get('min_price', ''));
        $max_price = trim(Input::get('max_price', ''));
        $item = MerchantModel::where('id', intval($id))->first();
        $categorys = MerchantCategoryModel::where('uid', intval($item->uid))
                            ->where('status', 0)->orderBy('sort', 'desc')->get();
        $goods = GoodsModel::where([
            'status' => 0,
            'uid' => $item->uid
        ])->SearchNavCategory($category)
            ->SearchTitle($keyword)
            ->SearchPrice([
                'min_price' => $min_price,
                'max_price' => $max_price
            ])->orderBy('updated_at', 'desc')->paginate(40);

        return view('home.even_morn', compact('id', 'categorys', 'goods'));
    }
}
