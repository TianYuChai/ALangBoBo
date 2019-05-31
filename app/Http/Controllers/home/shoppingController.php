<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/29
 * Time: 17:22
 */
namespace App\Http\Controllers\home;

use App\Http\Models\goods\GoodsModel;
use App\Http\Models\home\orderModel;
use App\Http\Models\home\personal\AddressModel;
use App\Http\Services\home\shoppingService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Log;

class shoppingController extends BaseController
{
    public function __construct(GoodsModel $goodsModel, AddressModel $addressModel)
    {
        $this->middleware(function ($request, $next) use ($goodsModel, $addressModel){
            $this->user = Auth::guard('web')->user();
            $this->goods = $goodsModel;
            $this->addressModel = $addressModel;
            return $next($request);
        });
    }

    /**
     * 购物：立即购买
     * @param $id
     * @param Request $request
     * @param shoppingService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function buyNow($id, Request $request, shoppingService $service)
    {
        try {
            $data = [$request->all()];
            $data[0]['id'] = intval($id);
            $order_id = $service->buyNow($data);
            return $this->ajaxReturn([
                'status' => 200,
                'url' => route('shopp.shopp.confirmorder', ['order_id' => $order_id])
            ], 200);
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }

    /**
     * 确认订单
     *
     * @param $order_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirmOrder($order_id)
    {
        try {
            $item = orderModel::where('order_id', strval($order_id))->first();
            $address = AddressModel::where([
                'uid' => $this->user->id,
                'category' => 800
            ])->orderBy('status', 'desc')->get();
            $data = [
                'orders' => $item,
                'address' => $address
            ];
            return view('home.confirm_order', compact('data'));
        } catch (Exception $e) {
            Log::info('确认订单查看页面: ', [
                'time' => getTime(),
                'order_id' => $order_id,
                'info' => $e->getMessage()
            ]);
        }
    }
}
