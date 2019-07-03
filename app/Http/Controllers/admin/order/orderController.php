<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/11
 * Time: 14:40
 */
namespace App\Http\Controllers\admin\order;

use App\Http\Controllers\admin\BaseController;
use App\Http\Models\home\shoppOrderModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Exception;
use Log;

class orderController extends BaseController
{
    const ROUTE = ADMING_ORDER; //视图路径

    public function index()
    {
        $order_id = trim(Input::get('order_id', ''));
        $status = trim(Input::get('status', ''));
        $items = shoppOrderModel::SearchOrderId($order_id)->SearchStatus($status)->orderBy('id', 'desc')->paginate(parent::$page_limit);
        $data = [
            'items' => $items,
            'status' => shoppOrderModel::$_STATUS
        ];
        return view(self::ROUTE . 'index', compact('data'));
    }

    public function show($id)
    {
        $item = shoppOrderModel::find($id);
        return view(self::ROUTE . 'show', compact('item'));
    }

    /**
     * 增加时长
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addTime($id, Request $request)
    {
        try {
            $number = trim($request->number);
            if(!regularHaveSinoram($number)) {
                throw new Exception('天数需为数字');
            }
            $item = shoppOrderModel::where('id', intval($id))
                ->whereIn('status', [300, 400, 500])
                ->where('timeout', '!=', '0000-00-00 00:00:00')
                ->where('pay_method', 'subscribed')->first();
            if (!$item) {
                throw new Exception('订单查询错误, 请刷新重试');
            }
            $item->timeout = Carbon::parse($item->timeout)
                                    ->modify('+' . intval($number) . ' days')
                                    ->toDateTimeString();
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
     * 取消订单
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelOrder($id)
    {
        try {
            $item = shoppOrderModel::where('id', intval($id))
                                ->whereIn('status', [300, 400, 500])
                                ->where('timeout', '!=', '0000-00-00 00:00:00')
                                ->where('pay_method', 'subscribed')->first();
            if (!$item) {
                throw new Exception('订单查询错误, 请刷新重试');
            }
            $item->status = 100;
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
