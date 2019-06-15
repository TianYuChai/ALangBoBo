<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/13
 * Time: 16:49
 */
namespace App\Http\Controllers\home;

use App\Http\Models\home\demandModel;
use Illuminate\Support\Facades\Auth;
use Log;
use Exception;
class demandController extends BaseController
{
    public function index()
    {
        $items = demandModel::where('status', 303)->paginate(40);
        return view('home.demand', compact('items'));
    }

    public function show($id)
    {
        $item = demandModel::find($id);
        return view('home.demand_show', compact('item'));
    }

    /**
     * 接单
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function send($id)
    {
        try {
            $item = demandModel::where([
                'id' => intval($id),
                'status' => 303
            ])->first();
            if($item) {
                $item->gid = Auth::guard('web')->user()->id;
                $item->status = 304;
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
