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

class PersonalHaveGoodsController extends BaseController
{
    const ROUTE = HOME_PERSONAL; //视图路径
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
        return view(self::ROUTE. 'haveToBuyGoods');
    }
}
