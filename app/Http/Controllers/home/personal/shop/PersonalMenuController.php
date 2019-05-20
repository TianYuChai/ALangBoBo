<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/9
 * Time: 16:39
 */
namespace App\Http\Controllers\home\personal\shop;

use App\Http\Controllers\home\BaseController;
use App\Http\Models\currency\MerchantCategoryModel;
use App\Http\Models\currency\MerchantModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use FileUpload;

class PersonalMenuController extends BaseController
{
    const ROUTE = HOME_PERSONAL_SHOP; //视图路径
    protected $merchatModel; //个人商户信息
    protected $categoryModel; //商家分类表
    protected $user;

    public function __construct(MerchantModel $merchantModel, MerchantCategoryModel $merchantCategoryModel)
    {
        $this->middleware(function ($request, $next) use ($merchantModel, $merchantCategoryModel){
            $this->merchatModel = $merchantModel;
            $this->categoryModel = $merchantCategoryModel;
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    public function index()
    {
        $items = $this->categoryModel::where([
            'uid' => $this->user->id,
            'status' => 0
        ])->orderBy('sort', 'desc')->get();
        return view(self::ROUTE . 'menu', compact('items'));
    }

    /**
     * 添加分类
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $name = trim($request->name);
            $sort = trim($request->sort);
            if(!$name) {
                throw new Exception('请输入分类名称');
            }
            if(!$sort) {
                throw new Exception('请输入分类排序');
            }
            if(!regularHaveSinoram($sort)) {
                throw new Exception('排序值, 不可用');
            }
            $this->categoryModel::create([
                'uid' => $this->user->id,
                'name' => $name,
                'sort' => intval($sort)
            ]);
            return $this->ajaxReturn([
                'status' => 200,
                'info' => '添加成功'
            ], 200);
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }

    /**
     * 获取内容
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $item = $this->categoryModel::where([
            'id' => intval($id),
            'uid' => $this->user->id,
            'status' => 0
        ])->first();
        return $this->ajaxReturn([
            'status' => 200,
            'data' => [
                'url' => route('personal.menu.update', ['id' => $item->id]),
                'name' => $item->name,
                'sort' => $item->sort
            ]
        ], 200);
    }

    /**
     * 修改内容
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        try {
            $name = trim($request->edit_name);
            $sort = trim($request->edit_sort);
            if(!$name) {
                throw new Exception('请输入分类名称');
            }
            if(!$sort) {
                throw new Exception('请输入分类排序');
            }
            $this->categoryModel::where([
                'id' => intval($id),
                'uid' => $this->user->id
            ])->update([
                'name' => $name,
                'sort' => $sort
            ]);
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
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
            $this->categoryModel::destroy($id);
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }
}
