<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/4
 * Time: 14:05
 */
namespace App\Http\Controllers\home\personal\shop;

use App\Http\Controllers\home\BaseController;
use App\Http\Models\home\orderModel;
use App\Http\Models\home\shoppOrderModel;
use App\Http\Services\home\persanal\PersonalOrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Exception;

class PersonalOrderController extends BaseController
{
    const ROUTE = HOME_PERSONAL_SHOP;

    protected static $types = [
        'allOrder' => '',
        'waitPay' => 200,
        'waitSend' => 300,
        'waitReceive' => 400,
        'waitEvaluate' => 500,
        'refund' => [
            700, 800, 900
        ]
    ];
    public function __construct(shoppOrderModel $model, orderModel $orderModel)
    {
        $this->middleware(function ($request, $next) use ($model, $orderModel){
            $this->user = Auth::guard('web')->user();
            $this->model = $model;
            $this->orderModel = $orderModel;
            return $next($request);
        });
    }

    public function index($type)
    {
        $status = self::$types[$type];
        $order_id = trim(Input::get('order_id', ''));
        $items = $this->model::where(function ($query) use ($status) {
            if(!empty($status)) {
                if(!is_array($status)) {
                    $query->where('status', $status);
                } else {
                    $query->whereIn('status', $status);
                }
            } else {
                $query->whereIn('status', [300, 400, 500, 600]);
            }
        })->where('gid', $this->user->id)
            ->SearchOrderId($order_id)
            ->orderBy('status', 'asc')->paginate(parent::$page_limit);
        $data = [
            'type' => $type,
            'items' => $items
        ];
        return view(self::ROUTE. 'order', compact('data'));
    }

    /**
     * 订单发货
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deliveryOrder($id, Request $request)
    {
        try {
            $this->model::where([
                'gid' => $this->user->id,
                'id' => intval($id),
                'status' => 300
            ])->first()->update([
                'courier_firm' => $request->name,
                'courier_code' => $request->code,
                'signtime' => Carbon::now()->modify('+10 days')->toDateTimeString(),
                'status' => 400
            ]);
            return $this->ajaxReturn([
                'status' => 200,
                'info' => '发货成功'
            ], 200);
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }

    /**
     * 修改发货信息
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editDeliveryOrder($id, Request $request)
    {
        try {
            $this->model::where([
                'id'=> intval($id),
                'gid' => $this->user->id,
            ])->update([
                'courier_firm' => $request->name,
                'courier_code' => $request->code
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
     * 商家同意退款
     *
     * @param $id
     * @param PersonalOrderService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function reimburse($id, PersonalOrderService $service)
    {
        try{
            $service->refund($id);
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }
}
