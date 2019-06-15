<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/6/15
 * Time: 22:50
 */
namespace App\Http\Controllers\admin\setup;

use App\Http\Controllers\admin\BaseController;
use App\Http\Models\setup\merchantServiceModel;
use App\Http\Models\setup\shoppDuiteModel;
use Illuminate\Http\Request;
use Exception;

class issueController extends BaseController
{
    const ROUTE = 'admin.setup.issue.';
    public function index()
    {
        $items = shoppDuiteModel::all();
        return view(self::ROUTE. 'shopp_guide.index', compact('items'));
    }

    public function duiteCteate()
    {
        return view(self::ROUTE. 'shopp_guide.created');
    }

    /**
     * 添加内容
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function duiteStore(Request $request)
    {
        try {
            $category = $request->category;
            if(shoppDuiteModel::where('category_id', intval($category))->exists()) {
                throw new Exception('该分类已存在内容, 不可重复添加');
            }
            shoppDuiteModel::create([
                'category_id' => intval($category),
                'title' => trim($request->title),
                'content' => $request->input('content')
            ]);
            return $this->ajaxReturn([
                'status' => 200,
                'info' => '添加成功',
                'url' => route('backstage.shopp_guide.duitecteate')
            ], 200);
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }
    public function duiteEdit($id)
    {
        $item = shoppDuiteModel::find($id);
        return view(self::ROUTE. 'shopp_guide.edit', compact('item'));
    }

    /**
     * 修改
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function duiteUpdate($id, Request $request)
    {
        try {
            $category = $request->category;
            if(shoppDuiteModel::where('id', '!=', intval($id))
                ->where('category_id', intval($category))->exists()) {
                throw new Exception('该分类已存在内容, 不可重复添加');
            }
            shoppDuiteModel::where('id', intval($id))->update([
                'category_id' => intval($category),
                'title' => trim($request->title),
                'content' => $request->input('content')
            ]);
            return $this->ajaxReturn([
                'status' => 200,
                'info' => '修改成功',
                'url' => route('backstage.shopp_guide.duitecteate')
            ], 200);
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }

    /**
     * 删除
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function duiteDel($id)
    {
        shoppDuiteModel::destroy($id);
        return $this->ajaxReturn();
    }
}