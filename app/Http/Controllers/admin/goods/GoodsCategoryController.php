<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/4
 * Time: 9:33
 */
namespace App\Http\Controllers\admin\goods;

use App\Http\Controllers\admin\BaseController;
use App\Http\Models\admin\goods\goodsCategoryModel;
use App\Http\Requests\admin\goods\categoryRequest;
use App\Http\Services\admin\Goods\goodsCategoryService;
use Exception;
use Illuminate\Http\Request;

class GoodsCategoryController extends BaseController
{
    const ROUTE = ADMIN_GOODS_CATEGORY; //视图路径

    /**
     * 分类展示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view(self::ROUTE. 'index');
    }

    /**
     * 分类添加
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $items = goodsCategoryModel::where([
            'status' => 0,
            'p_id' => 0
        ])->get(['id', 'cate_name']);

        return view(self::ROUTE. 'create', compact('items'));
    }

    /**
     * 添加分类
     *
     * @param categoryRequest $request
     * @param goodsCategoryService $goodsCategoryService
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(categoryRequest $request, goodsCategoryService $goodsCategoryService)
    {
        try {
            $data = $goodsCategoryService->messageFile($request);
            $goodsCategoryService->setMessage($data);
            return $this->ajaxReturn();
        } catch (Exception $exception) {
            return $this->ajaxReturn([
                'info' => $exception->getMessage(),
                'status' => 510
            ], 510);
        }
    }

    /**
     * 联动查询分类
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function select(Request $request)
    {
        $items = goodsCategoryModel::where([
            'status' => 0,
            'p_id' => intval($request->id)
        ])->get(['id', 'cate_name'])->toArray();

        return $this->ajaxReturn([
            'info' => '请求成功',
            'status' => 200,
            'data' => $items
        ], 200);
    }
}
