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
use App\Http\Models\home\shoppOrderModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class PersonalHaveGoodsController extends BaseController
{
    const ROUTE = HOME_PERSONAL; //视图路径
    protected static $types = [
        'allOrder' => '',
        'waitPay' => 200,
        'waitSend' => 300,
        'waitReceive' => 400,
        'waitEvaluate' => 500
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
                $query->where('status', $status);
            }
        })->SearchOrderId($order_id)->orderBy('status', 'asc')->paginate(parent::$page_limit);
        $data = [
            'type' => $type,
            'items' => $items
        ];
        return view(self::ROUTE. 'haveToBuyGoods', compact('data'));
    }
}
