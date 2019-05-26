<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/5/25
 * Time: 15:42
 */
namespace APP\Http\Controllers\admin\goods;

use App\Http\Controllers\admin\BaseController;
use App\Http\Models\goods\GoodsModel;
use Exception;
use Input;

class GoodsAdminController extends BaseController
{
    const ROUTE = ADMIN_GOODS_CATEGORY; //视图路径

    public function makeQuery($query)
    {
        $name = trim(Input::get('account_name', ''));
        $status = trim(Input::get('status', ''));
        $query = $query->SearchAccount($name);
        if(empty($status) || $status == '0') {
            $query = $query->where('status', 0);
        } else {
            $query = $query->SearchStatus($status);
        }
        return $query;
    }

    public function index()
    {
        $query = $this->makeQuery(new GoodsModel());
        $items = $query->orderBy('id', 'desc')->paginate(parent::$page_limit);
        $data = [
            'items' => $items,
            'goods_count' => $items->count()
        ];
        return view(self::ROUTE . 'index', compact('data'));
    }

    /**
     * 操作商品状态
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function operStatus($id)
    {
        try {
            $item = GoodsModel::find($id);
            if(!$item) {
                throw new Exception('数据错误，请刷新重试');
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
     * 数据展示
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws Exception
     */
    public function show($id)
    {
        $item = GoodsModel::find($id);
        if(!$item) {
            throw new Exception('数据错误，请刷新重试');
        }
        return view(self::ROUTE . 'details', compact('item'));
    }
}