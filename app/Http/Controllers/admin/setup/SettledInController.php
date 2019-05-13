<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/5/13
 * Time: 21:19
 */
namespace App\Http\Controllers\admin\setup;

use App\Http\Controllers\admin\BaseController;
use App\Http\Models\setup\SettledModel;
use Illuminate\Http\Request;
use Exception;

class SettledInController extends BaseController
{
//    系统设置--商家入驻费设置
    const ROUTE = "admin.setup.shopsettledin.";
    protected $model;

    public function __construct(SettledModel $model)
    {
        return $this->model = $model;
    }

    public function index()
    {
        $items = SettledModel::orderBy('sort', 'desc')->paginate(parent::$page_limit);
        $data = [
            'items' => $items,
            'count' => $items->count()
        ];
        return view(self::ROUTE. 'index', compact('data'));
    }

    /**
     * 展示添加页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View、
     */
    public function create()
    {
        return view(self::ROUTE. 'create');
    }

    /**
     * 数据添加
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $money = trim($request->money);
            if(!regularHaveSinoram($request->money)) {
                throw new Exception('金额错误');
            }
            $this->model::create([
                'name' => trim($request->name),
                'money' => $money,
                'sort' => intval(trim($request->sort))
            ]);
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => 510
            ], 510);
        }
    }

    /**
     * 删除数据
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function del($id)
    {
        try {
            $this->model::destroy($id);
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => 510
            ], 510);
        }
    }
}