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
use App\Http\Models\home\shoppCarModel;
use App\Http\Services\home\shoppingService;
use App\Http\Services\home\shoppPayService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Log;

class shoppingController extends BaseController
{
    public function __construct(GoodsModel $goodsModel, AddressModel $addressModel, shoppCarModel $shoppCarModel)
    {
        $this->middleware(function ($request, $next) use ($goodsModel, $addressModel, $shoppCarModel){
            $this->user = Auth::guard('web')->user();
            $this->goods = $goodsModel;
            $this->addressModel = $addressModel;
            $this->shoppCarModel = $shoppCarModel;
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
     * 加入购物车
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function shoppCart($id, Request $request)
    {
        try {
            $item = $this->goods::where('id', intval($id))->first();
            if(!$item) {
                throw new Exception('加入失败，商品不存在');
            }
            $this->shoppCarModel::updateOrCreate([
                'uid' => $this->user->id,
                'gid' => $item->uid,
                'sid' => $item->id
            ],[
                'uid' => $this->user->id,
                'gid' => $item->uid,
                'sid' => $item->id,
                'few' => intval(trim($request->num)),
                'attribute' => json_encode($request->attribute),
                'pay_method' => trim($request->pay_method)
            ]);
            return $this->ajaxReturn([
                'status' => 200,
                'info' => '已加入'
            ], 200);
        } catch (Exception $e) {
            Log::info('商品加入购物车: ', [
                'time' => getTime(),
                'user_id' => $this->user->id,
                'goods_id' => $id,
                'info' => $e->getMessage()
            ]);
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }

    /**
     * 购物车展示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function shoppCar()
    {
        try {
            $items = $this->shoppCarModel::where('uid', $this->user->id)->get();
            $data = [];
            foreach ($items as $item) {
                if(isset($data[$item->gid])) {
                    $data[$item->gid]['data'][] = $item;
                } else {
                    $data[$item->gid] = [
                        'id' => $item->gid,
                        'name' => $item->merchant->shop_name,
                        'code' => $item->merchant->code,
                        'data' => [$item]
                    ];
                }
            }
            $data = array_values($data);
            return view('home.shopp_car', compact('data'));
        } catch (Exception $e) {
            Log::info('购物车: ', [
                'time' => getTime(),
                'user_id' => $this->user->id,
                'info' => $e->getMessage()
            ]);
        }
    }

    /**
     * 清除购物车商品
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delGoods(Request $request)
    {
        try {
            $this->shoppCarModel::destroy($request->ids);
            return $this->ajaxReturn();
        } catch (Exception $e) {
            Log::info('清除购物车单个商品: ', [
                'time' => getTime(),
                'user_id' => $this->user->id,
                'info' => $e->getMessage()
            ]);
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }

    /**
     * 结算购物车商品
     *
     * @param Request $request
     * @param shoppingService $shoppingService
     * @return \Illuminate\Http\JsonResponse
     */
    public function shoppSettlement(Request $request, shoppingService $shoppingService)
    {
        try {
            $ids = array_column($request->data, 'id');
            if (empty($ids)) {
                throw new Exception('请选择结算商品');
            }
            $items = $this->shoppCarModel::whereIn('id', $ids)->get();
            $result = [];
            foreach ($request->data as $datum) {
                $item = $items->where('id', $datum['id'])->first();
                $result[] = [
                    'id' => intval($item->sid),
                    'num' => intval($datum['num']),
                    'pay_method' => $item->pay_method,
                    'attribute' => json_decode($item->attribute),
                ];
            }
            $order_id = $shoppingService->buyNow($result);
            if($order_id) {
                $this->shoppCarModel::destroy($ids);
            }
            return $this->ajaxReturn([
                'status' => 200,
                'url' => route('shopp.shopp.confirmorder', ['order_id' => $order_id])
            ], 200);
        } catch (Exception $e) {
            Log::info('结算购物车商品: ', [
                'time' => getTime(),
                'user_id' => $this->user->id,
                'data' => $request->all(),
                'info' => $e->getMessage()
            ]);
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

    /**
     * 支付
     *
     * @param $order_id
     * @param Request $request
     * @param shoppPayService $service
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function store($order_id, Request $request, shoppPayService $service)
    {
        try {
            $result = $service->entrance($order_id, $request->all());
            if(is_array($result)) {
                return $this->ajaxReturn([
                    'status' => 200,
                    'info' => $result['info'],
                    'url' => $result['url'],
                ], 200);
            } else {
                return $result;
            }
        } catch (Exception $e) {
            Log::info('提交订单支付: ', [
                'time' => getTime(),
                'order_id' => $order_id,
                'info' => $e->getMessage()
            ]);
            return $this->ajaxReturn([
                'status' => $e->getCode(),
                'info' => $e->getMessage()
            ], $e->getCode());
        }
    }

    /**
     * 支付宝
     * 异步回调
     *
     * @param shoppingService $shoppingService
     * @return mixed
     */
    public function notify(shoppPayService $shoppPayService)
    {
        try {
            $result = $shoppPayService->notify();
        } catch (Exception $e) {
            Log::info('支付宝异步回调错误:' . $e->getMessage());
        }
        return $result;
    }

    /**
     * 微信
     * 异步回调
     *
     * @param shoppingService $shoppingService
     * @return mixed
     */
    public function wxnotify(shoppPayService $shoppPayService)
    {
        try {
            $result = $shoppPayService->wxnotify();
        } catch (Exception $e) {
            Log::info('微信异步回调错误:' . $e->getMessage());
        }
        return $result;
    }
}
