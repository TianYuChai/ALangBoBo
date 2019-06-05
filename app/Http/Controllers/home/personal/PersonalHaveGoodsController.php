<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/3
 * Time: 17:36
 */
namespace App\Http\Controllers\home\personal;

use App\Http\Controllers\home\BaseController;
use App\Http\Models\home\orderModel;
use App\Http\Models\home\personal\AddressModel;
use App\Http\Models\home\shoppOrderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Exception;

class PersonalHaveGoodsController extends BaseController
{
    const ROUTE = HOME_PERSONAL; //视图路径
    protected static $types = [
        'allOrder' => '',
        'waitPay' => 200,
        'waitSend' => 300,
        'waitReceive' => 400,
        'waitEvaluate' => 500,
        'refund' => [700, 800, 900]
    ];
    /**
     * php 魔术方法获取用户id
     *
     * PersonalContentController constructor.
     */
    public function __construct(shoppOrderModel $model, orderModel $orderModel)
    {
        $this->middleware(function ($request, $next) use ($model, $orderModel){
            $this->userId = Auth::guard('web')->user()->id;
            $this->model = $model;
            $this->addressModel = $orderModel;
            return $next($request);
        });
    }

    public function index($type)
    {
        $status = self::$types[$type];
        $order_id = trim(Input::get('order_id', ''));
        $items = $this->model::where(function ($query) use ($status) {
            $query->where('uid', $this->userId);
            if(!empty($status)) {
                if(!is_array($status)) {
                    $query->where('status', $status);
                } else {
                    $query->whereIn('status', $status);
                }
            }
        })->SearchOrderId($order_id)->orderBy('status', 'asc')->paginate(parent::$page_limit);
        $data = [
            'type' => $type,
            'items' => $items
        ];
        return view(self::ROUTE. 'haveToBuyGoods', compact('data'));
    }

    /**
     * 订单展示
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $item = $this->model::find($id);
        return view(self::ROUTE . 'order_show', compact('item'));
    }

    /**
     * 订单签收
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function sign($id)
    {
        try {
            $this->model::where([
                'uid' => $this->userId,
                'id' => intval($id),
                'status' => 400
            ])->first()->update([
                'status' => 500,
                'signtime' => ''
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
     * 取消订单
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delOrder($id)
    {
        try{
            $this->model::where([
                'id' => intval($id),
                'uid' => $this->userId,
                'status' => 200
            ])->first()->update([
                'status' => 100
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
     * 申请退款
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refundOrder($id, Request $request)
    {
        try {
            $message = trim($request->message);
            $this->model::where([
                'id' => intval($id),
                'uid' => $this->userId,
            ])->whereIn('status', [300, 400])->update([
               'status' => 700,
               'refund' => $message
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
