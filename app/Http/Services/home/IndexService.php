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
use App\Http\Models\home\evaluationModel;
use App\Http\Models\home\shoppOrderModel;
use Illuminate\Support\Facades\DB;

class IndexService extends BaseService
{
    public function entrance()
    {
        $categorys = $this->category();
        $banners = $this->banner();
        $sellingGoods = $this->sellingGoods();
        $good_business = $this->goodBusiness();
        $good_business_category = $this->goodBusinessCategory();
        return [
            'categorys' => $categorys,
            'banners' => $banners,
            'selling_goods' => $sellingGoods,
            'good_business' => $good_business,
            'good_business_category' => $good_business_category
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

    /**
     * 优秀商家
     *
     * @return array
     */
    public function goodBusiness()
    {
        $result = [];
        $data = GoodsModel::whereIn('goods.main_category', [6, 1])
                                            ->leftJoin('evaluation', 'goods.id', '=', 'evaluation.sid')
                                            ->select(DB::raw('albb_goods.*, avg(albb_evaluation.satisfaction) as avg_value'))
                                            ->where('goods.status', 0)
                                            ->orderBy('avg_value', 'desc')
                                            ->groupBy('evaluation.sid')
                                            ->get();
        foreach ($data as $datum) {
            if(isset($result[$datum->main_category]) && count($result[$datum->main_category]) < 5) {
                $result[$datum->main_category][] = $datum;
            } else {
                if(!isset($result[$datum->main_category])) {
                    $result[$datum->main_category][] = $datum;
                }
            }
        }
        return $result;
    }

    /**
     * 优秀商家分类
     *
     * @return array
     */
    public function goodBusinessCategory()
    {
        return [
            [
                'id' => 6,
                'value' => '百货类'
            ],
            [
                'id' => 1,
                'value' => '数码类'
            ],
        ];
    }
}
