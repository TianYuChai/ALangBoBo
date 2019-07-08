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
use App\Http\Models\goods\goodsAttributeModel;
use App\Http\Models\goods\GoodsModel;
use App\Http\Models\home\personal\AddressModel;
use App\Http\Requests\home\persanal\PersonalGoodsRequest;
use App\Http\Services\home\persanal\PersonalGoodsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Input;

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
                                AddressModel $addressModel, GoodsModel $goodsModel,
                                goodsAttributeModel $goodsAttributeModel)
    {
        $this->middleware(function ($request, $next) use ($merchantCategoryModel,
            $goodsCategoryModel, $goodsCategoryAttributeModel, $addressModel, $goodsModel,
            $goodsAttributeModel){

            $this->user = Auth::guard('web')->user();
            $this->merchantCategory = $merchantCategoryModel;
            $this->goodsCategory = $goodsCategoryModel;
            $this->goodsAttribute = $goodsCategoryAttributeModel;
            $this->addressModel = $addressModel;
            $this->goodsModel = $goodsModel;
            $this->goodsAttributes = $goodsAttributeModel;
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
        $keywords = trim(Input::get('title', ''));
        $sort = trim(Input::get('sort', 'updated_at'));
        $items = $this->goodsModel::where('uid', $this->user->id)
                        ->SearchTitle($keywords)->orderBy($sort, 'desc')->paginate(parent::$page_limit);
        //店铺分类
        $merchantCategorys = $this->merchantCategory::where([
            'uid' => $this->user->id,
            'status' => 0,
        ])->orderBy('sort', 'desc')->get();
        //商品分类
        $goodsCategorys = $this->goodsCategory::where([
            'status' => 0,
            'p_id' => 0
        ])->where('id', '!=', 124)->orderBy('sort', 'desc')->get();
        //地址
        $address = $this->addressModel::where([
            'uid' => $this->user->id,
            'category' => 900
        ])->where('status', 700)->orWhere('status', 703)->get();
        return view(self::Route . 'goods', [
            'menuCategorys' => $merchantCategorys,
            'goodsCategorys' => $goodsCategorys,
            'address' => $address,
            'items' => $items
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

    /**
     * 添加商品
     * 
     * @param PersonalGoodsRequest $request
     * @param PersonalGoodsService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PersonalGoodsRequest $request,
                          PersonalGoodsService $service)
    {
        try {
            $data = $service->dataFiltering($request);
            $service->create($data);
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }

    /**
     * 修改商品状态
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function operStatus($id)
    {
        try {
            $item = $this->goodsModel::where([
                'id' => intval($id),
                'uid' => $this->user->id
            ])->first();
            if(!$item) {
                throw new Exception('数据不存在, 请刷新重试');
            }
            $item->status = $item->status == 0 ? 1 : 0;
            $item->save();
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }

    /**
     * 展示修改数据
     * 考虑分类后期多的情况，此处三层分类分开查询。不做无限分类操作
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $item = $this->goodsModel::where([
            'id' => intval($id),
            'uid' => $this->user->id
        ])->first();
        //店铺分类
        $merchantCategorys = $this->merchantCategory::where([
            'uid' => $this->user->id,
            'status' => 0,
        ])->orderBy('sort', 'desc')->get();
        //商品分类
        $goodsMainCategorys = $this->goodsCategory::where([
            'status' => 0,
            'p_id' => 0
        ])->where('id', '!=', 124)->orderBy('sort', 'desc')->get();
        $goodsSubCategorys = $this->goodsCategory::where([
            'status' => 0,
            'level' => 2
        ])->orderBy('sort', 'desc')->get();
        $goodsThreeCategorys = $this->goodsCategory::where([
            'status' => 0,
            'level' => 3
        ])->orderBy('sort', 'desc')->get();
        //地址
        $address = $this->addressModel::where([
            'uid' => $this->user->id,
            'category' => 900
        ])->where('status', 700)->orWhere('status', 703)->get();
        return view(self::Route . 'goods_edit', [
            'menuCategorys' => $merchantCategorys,
            'goodsCategorys' => [
                'mainCategorys' => $goodsMainCategorys,
                'goodsSubCategorys' => $goodsSubCategorys,
                'goodsThreeCategorys' => $goodsThreeCategorys
            ],
            'address' => $address,
            'item' => $item
        ]);
    }

    /**
     * 更新数据
     *
     * @param $id
     * @param PersonalGoodsRequest $request
     * @param PersonalGoodsService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, PersonalGoodsRequest $request,
                                PersonalGoodsService $service)
    {
        try {
            $data = $service->dataFiltering($request);
            $service->update($id, $data);
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }

    /**
     * 删除已选商品属性
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delAttribute($id)
    {
        try {
            if(!$this->goodsAttributes::where('id', intval($id))->exists()) {
                throw new Exception('数据错误, 请刷新重试');
            }
            $this->goodsAttributes::destroy($id);
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }

    /**
     * 店长推荐
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function recom($id)
    {
        try {
            $item = $this->goodsModel::where([
                'id' => intval($id),
                'uid' => $this->user->id
            ])->first();
            if(!$item) {
                throw new Exception('数据不存在, 请刷新重试');
            }
            $item->recom = $item->recom == 0 ? 1 : 0;
            $item->save();
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }
}
