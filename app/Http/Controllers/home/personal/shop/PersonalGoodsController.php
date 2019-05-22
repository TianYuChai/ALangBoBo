<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/21
 * Time: 9:20
 */
namespace App\Http\Controllers\home\personal\shop;

use App\Http\Controllers\home\BaseController;
use App\Http\Models\admin\goods\goodsCategoryAttributeModel;
use App\Http\Models\admin\goods\goodsCategoryModel;
use App\Http\Models\currency\MerchantCategoryModel;
use App\Http\Models\home\personal\AddressModel;
use App\Http\Requests\home\persanal\PersonalGoodsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class PersonalGoodsController extends BaseController
{
    const Route = HOME_PERSONAL_SHOP;
    protected $merchantCategory; //店铺导航分类
    protected $goodsCategory; //商品分类
    protected $goodsAttribute; //商品分类属性
    protected $addressModel; //地址信息
    public function __construct(MerchantCategoryModel $merchantCategoryModel,
                                goodsCategoryModel $goodsCategoryModel,
                                goodsCategoryAttributeModel $goodsCategoryAttributeModel,
                                AddressModel $addressModel)
    {
        $this->middleware(function ($request, $next) use ($merchantCategoryModel,
            $goodsCategoryModel, $goodsCategoryAttributeModel, $addressModel){
            $this->user = Auth::guard('web')->user();
            $this->merchantCategory = $merchantCategoryModel;
            $this->goodsCategory = $goodsCategoryModel;
            $this->goodsAttribute = $goodsCategoryAttributeModel;
            $this->addressModel = $addressModel;
            return $next($request);
        });
    }

    /**
     * 展示店铺导航分类和商品分类
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $merchantCategorys = $this->merchantCategory::where([
            'uid' => $this->user->id,
            'status' => 0,
        ])->orderBy('sort', 'desc')->get();
        $goodsCategorys = $this->goodsCategory::where([
            'status' => 0,
            'p_id' => 0
        ])->orderBy('sort', 'desc')->get();
        $address = $this->addressModel::where([
            'uid' => $this->user->id,
            'category' => 900
        ])->get();
        return view(self::Route . 'goods', [
            'menuCategorys' => $merchantCategorys,
            'goodsCategorys' => $goodsCategorys,
            'address' => $address
        ]);
    }

    /**
     * 分类筛选
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function select(Request $request)
    {
        try {
            $items = $this->goodsCategory::with('attribute')->where([
                'status' => 0,
                'p_id' => intval($request->id)
            ])->orderBy('sort', 'desc')->get();
            $attribute = [];
            if(!$items->isEmpty() && !$items[0]->attribute->isEmpty()) {
                foreach ($items[0]->attribute as $item) {
                    $attribute[$item->attribute_name][] = $item;
                }
            }
            return $this->ajaxReturn([
                'status' => 200,
                'level' => $items->isEmpty() ? '' : $items[0]->level == 2 ? "second" : "three",
                'data' => $items,
                'attribute' => $attribute
            ], 200);
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }

    /**
     * 获取商品分类属性
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function attribute(Request $request)
    {
        try {
            $attribute = [];
            $id = trim($request->id);
            $items = $this->goodsAttribute::where([
                'cate_id' => intval($id),
                'status' => 0
            ])->get();
            foreach ($items as $item) {
                $attribute[$item->attribute_name][] = $item;
            }
            return $this->ajaxReturn([
                'status' => 200,
                'data' => $attribute
            ], 200);
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }

    public function store(PersonalGoodsRequest $request)
    {
        dd($request->all());
    }
}
