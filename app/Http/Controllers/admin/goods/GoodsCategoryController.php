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
use App\Http\Models\admin\goods\goodsCategoryAttributeModel;
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
        $items = goodsCategoryModel::orderBy('sort', 'desc')->get();
        $data = json_encode(infiniteCate($items, 0));
        return view(self::ROUTE. 'category.index', compact('data'));
    }


    /**
     * 分类添加
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $items = goodsCategoryModel::where([
            'status' => 0,
            'p_id' => 0
        ])->get(['id', 'cate_name']);

        return view(self::ROUTE. 'category.create', compact('items'));
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
            $data = $goodsCategoryService->messageFile('', $request);
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
     * 编辑展示页
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $item = goodsCategoryModel::find($id);
        $category = array_sorts(getTopComId(goodsCategoryModel::get(), $id), 'level', SORT_ASC);
        return view(self::ROUTE .'category.edit', compact('item', 'category'));
    }

    public function update($id, Request $request, goodsCategoryService $goodsCategoryService)
    {
        try {
            $data = $goodsCategoryService->messageFile($id, $request);
            $goodsCategoryService->updateMessage($id, $data);
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

    /**
     * 分类禁启用
     *
     * @param $id
     * @param goodsCategoryService $goodsCategoryService
     * @return \Illuminate\Http\JsonResponse
     */
    public function bannedOperation($id, goodsCategoryService $goodsCategoryService)
    {
       try {
           $item = goodsCategoryModel::findOrFail($id);
           $item->status = $item->status == 0 ? 1 : 0;
           $goodsCategoryService->banKai($item->id, $item->status);
           $item->save();
           return $this->ajaxReturn();
       } catch (Exception $exception) {
           return $this->ajaxReturn([
               'info' => $exception->getMessage(),
               'status' => 510
           ], 510);
       }
    }

    public function bannedAttriStatus($id)
    {
        try {
            goodsCategoryAttributeModel::where('id', intval($id))->update(['status' => 1]);
            return $this->ajaxReturn();
        } catch (Exception $exception) {
            return $this->ajaxReturn([
                'info' => "非法执行, 操作数据有误",
                'status' => 510
            ], 510);
        }
    }
}
