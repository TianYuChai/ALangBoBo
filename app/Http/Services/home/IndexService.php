<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/15
 * Time: 15:40
 */
namespace App\Http\Services\home;


use App\Http\Models\admin\goods\BannerModel;
use App\Http\Models\admin\goods\goodsCategoryModel;
use App\Http\Models\goods\GoodsModel;
use App\Http\Models\home\shoppOrderModel;
use Illuminate\Support\Facades\DB;

class IndexService extends BaseService
{
    public function entrance()
    {
        $categorys = $this->category();
        $banners = $this->banner();
        $sellingGoods = $this->sellingGoods();
        return [
            'categorys' => $categorys,
            'banners' => $banners,
            'selling_goods' => $sellingGoods
        ];
    }

    /**
     * 商品分类
     *
     * @return array
     */
    public function category()
    {
        $all_category = goodsCategoryModel::where([
            'status' => 0,
        ])->orderBy('sort', 'desc')->get();

        return infiniteCate($all_category);
    }

    /**
     * banner图
     *
     * @return mixed
     */
    public function banner()
    {
        return BannerModel::where([
            'status' => 1
        ])->orderBy('sort', 'desc')->get(['image_url', 'url', 'sort']);
    }

    /**
     * 热卖商品
     *
     * @return mixed
     */
    public function sellingGoods()
    {
        $shopp_order_goods = shoppOrderModel::select(DB::raw('*, count(id) as ids'))
                                ->groupBy('sid')->orderBy('ids', 'desc')->limit(6)->get();
        return GoodsModel::whereIn('id', $shopp_order_goods->pluck('sid')->toArray())->get();
    }
}
