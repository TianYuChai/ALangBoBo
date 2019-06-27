<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/27
 * Time: 14:37
 */
namespace App\Http\Controllers\admin\other;

use App\Http\Controllers\admin\BaseController;
use App\Http\Models\setup\complainModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
class complainController extends BaseController
{
    public function index()
    {
        $status = Input::get('status', '');
        $items = complainModel::orderBy('id', 'desc')->SearchStatus($status)->paginate(parent::$page_limit);
        $data = [
            'items' => $items,
            'complain_count' => $items->count()
        ];
        return view('admin.other.complain.index', compact('data'));
    }

    /**
     * 处理结果
     *
     * @param $id
     * @param $type
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle($id, $type, Request $request)
    {
        try {
            $result = trim($request->result);
            complainModel::where('id', intval($id))->update([
                'result' => $result,
                'status' => intval($type)
            ]);
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }
}
