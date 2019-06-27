<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/27
 * Time: 15:43
 */
namespace App\Http\Controllers\admin\setup;

use App\Http\Controllers\admin\BaseController;
use App\Http\Models\setup\kefuModel;
use Illuminate\Http\Request;
use Exception;

class keFuController extends BaseController
{
    public function index()
    {
        $item = kefuModel::first();
        return view('admin.other.kefu.index', compact('item'));
    }

    /**
     * 添加修改
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $content = trim($request->input('content'));
            $item = kefuModel::first();
            if(!$item) {
                kefuModel::create([
                    'content' => $content
                ]);
            } else {
                $item->content = $content;
                $item->save();
            }
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }
}
