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
use App\Http\Models\home\demandModel;
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
        $demands = $this->demands();
        $recreationProducts = $this->recreationProducts();
        $recreationProductss = $this->recreationProductss();
        $presellGoods = $this->presellGoods();
        $presellGoodss = $this->presellGoodss();
        $commissionCategory = $this->commissionCategory();
        $commissions = $this->commissions();
        $beauty = $this->beauty();
        $beautys = $this->beautys();
        return [
            'categorys' => $categorys,
            'banners' => $banners,
            'selling_goods' => $sellingGoods,
            'good_business' => $good_business,
            'good_business_category' => $good_business_category,
            'demands' => $demands,
            'recreationProducts' => $recreationProducts,
            'recreationProductss' => $recreationProductss,
            'presellGoods' =>  $presellGoods,
            'presellGoodss' =>  $presellGoodss,
            'commissionCategory' => $commissionCategory,
            'commissions' => $commissions,
            'beauty' => $beauty,
            'beautys' => $beautys
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
        ])->where('id', '!=', 124)
          ->where('p_id', '!=', 124)
          ->orderBy('sort', 'desc')->get();

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
        return GoodsModel::whereIn('id', $shopp_order_goods->pluck('sid')->toArray())
                                    ->where('status', 0)->get();
    }

    /**
     * 优秀商家
     *
     * @return array
     */
    public function goodBusiness()
    {
        $result = [];
        $data = GoodsModel::whereIn('goods.main_category', [26, 25, 19, 105])
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
                'id' => 26,
                'value' => '百货类'
            ],
            [
                'id' => 25,
                'value' => '数码类'
            ],
            [
                'id' => 19,
                'value' => '服装类'
            ],
            [
                'id' => 105,
                'value' => '美容类'
            ],
        ];
    }

    /**
     * 娱乐产品
     *
     * @return array
     */
    public function recreationProducts()
    {
        return [
            [
                'id' => 25,
                'value' => '数码类'
            ],
            [
                'id' => 19,
                'value' => '服装类'
            ],
            [
                'id' => 23,
                'value' => '旅行类'
            ],
            [
                'id' => 105,
                'value' => '美容类'
            ],
            [
                'id' => 22,
                'value' => '房宿类'
            ]
        ];
    }

    /**
     * 预售商品
     *
     * @return array
     */
    public function presellGoods()
    {
        return [
            [
                'id' => 19,
                'value' => '服装类'
            ],
            [
                'id' => 24,
                'value' => '代办类'
            ],
            [
                'id' => 22,
                'value' => '房宿类'
            ],
            [
                'id' => 25,
                'value' => '数码类'
            ],
        ];
    }

    /**
     * 预售商品
     *
     * @return array
     */
    public function presellGoodss()
    {
        $result = [];
        $data = GoodsModel::whereIn('goods.main_category', [19, 24, 22, 25])
                            ->leftJoin('evaluation', 'goods.id', '=', 'evaluation.sid')
                            ->select(DB::raw('albb_goods.*, avg(albb_evaluation.satisfaction) as avg_value'))
                            ->where('goods.status', 0)
                            ->where('goods.presell_time', '!=', '')
                            ->orderBy('avg_value', 'desc')
                            ->groupBy('evaluation.sid')
                            ->get();
        foreach ($data as $datum) {
            if(isset($result[$datum->main_category]) && count($result[$datum->main_category]) < 8) {
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
     * 娱乐商品
     */
    public function recreationProductss()
    {
        $result = [];
        $data = GoodsModel::whereIn('goods.main_category', [25, 19, 23, 105, 22])
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
     * 百录倩影
     *
     * @return array
     */
    public function demands()
    {
        $result = [];
        $items = demandModel::where('gid', 0)->where('status', 303)
                                ->orderBy('id', 'desc')->get();
        foreach ($items as $item) {
            if(isset($result[$item->display]) && count($result[$item->display]) < 8) {
                $result[$item->display][] = $item;
            } else {
                if(!isset($result[$item->display])) {
                    $result[$item->display][] = $item;
                }
            }
        }
        return $result;
    }

    /**
     * 代办分类
     *
     * @return mixed
     */
    public function commissionCategory()
    {
        return goodsCategoryModel::where('p_id', 24)->where('status', 0)->get();
    }

    /**
     * 代办分类值
     *
     * @return array
     */
    public function commissions()
    {
        $result = [];
        $data = GoodsModel::whereIn('goods.sub_category', $this->commissionCategory()->pluck('id')->toArray())
                                ->leftJoin('evaluation', 'goods.id', '=', 'evaluation.sid')
                                ->select(DB::raw('albb_goods.*, avg(albb_evaluation.satisfaction) as avg_value'))
                                ->where('goods.status', 0)
                                ->orderBy('avg_value', 'desc')
                                ->groupBy('evaluation.sid')
                                ->get();
        foreach ($data as $datum) {
            if(isset($result[$datum->sub_category]) && count($result[$datum->sub_category]) < 8) {
                $result[$datum->sub_category][] = $datum;
            } else {
                if(!isset($result[$datum->sub_category])) {
                    $result[$datum->sub_category][] = $datum;
                }
            }
        }
        return $result;
    }

    /**
     * 美容类
     *
     * @return mixed
     */
    public function beauty()
    {
        return goodsCategoryModel::where('p_id', 105)->where('status', 0)->get();
    }

    public function beautys()
    {
        $result = [];
        $data = GoodsModel::whereIn('goods.sub_category', $this->beauty()->pluck('id')->toArray())
                                    ->leftJoin('evaluation', 'goods.id', '=', 'evaluation.sid')
                                    ->select(DB::raw('albb_goods.*, avg(albb_evaluation.satisfaction) as avg_value'))
                                    ->where('goods.status', 0)
                                    ->orderBy('avg_value', 'desc')
                                    ->groupBy('evaluation.sid')
                                    ->get();
        foreach ($data as $datum) {
            if(isset($result[$datum->sub_category]) && count($result[$datum->sub_category]) < 5) {
                $result[$datum->sub_category][] = $datum;
            } else {
                if(!isset($result[$datum->sub_category])) {
                    $result[$datum->sub_category][] = $datum;
                }
            }
        }
        return $result;
    }
}
