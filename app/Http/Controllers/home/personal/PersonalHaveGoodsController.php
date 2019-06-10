<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/3
 * Time: 17:36
 */
namespace App\Http\Controllers\home\personal;

use App\Http\Controllers\home\BaseController;
use App\Http\Models\currency\CapitalModel;
use App\Http\Models\currency\UserModel;
use App\Http\Models\home\evaluationModel;
use App\Http\Models\home\orderModel;
use App\Http\Models\home\personal\AddressModel;
use App\Http\Models\home\shoppOrderModel;
use App\Http\Services\home\persanal\PersonalHaveGoodsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Exception;
use Yansongda\Pay\Pay;
use Log;

class PersonalHaveGoodsController extends BaseController
{
    const ROUTE = HOME_PERSONAL; //视图路径
    protected static $types = [
        'allOrder' => '',
        'waitPay' => 200,
        'waitSend' => 300,
        'waitReceive' => 400,
        'waitEvaluate' => [500, 600],
        'refund' => [700, 800, 900]
    ];
    /**
     * php 魔术方法获取用户id
     *
     * PersonalContentController constructor.
     */
    public function __construct(shoppOrderModel $model,
                                orderModel $orderModel,
                                evaluationModel $evaluationModel,
                                CapitalModel $capitalModel)
    {
        $this->middleware(function ($request, $next) use ($model, $orderModel, $evaluationModel, $capitalModel){
            $this->userId = Auth::guard('web')->user()->id;
            $this->model = $model;
            $this->orderModel = $orderModel;
            $this->evaluationModel = $evaluationModel;
            $this->capitalModel = $capitalModel;
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
                'signtime' => Carbon::now()->modify('+7 days')->toDateTimeString()
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

    /**
     * 评价
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function evaluation($id, Request $request)
    {
        try {
            $satisfaction = trim($request->satisfaction);
            if(empty($satisfaction)) {
                throw new Exception('请对本订单进行评价');
            }
            $item = $this->model::where([
                'id' => intval($id),
                'uid' => $this->userId,
                'status' => 500
            ])->first();
            if(!$item) {
                throw new Exception('数据错误');
            }
            if($this->evaluationModel::where('order_id', $item->id)->exists()) {
                throw new Exception('该订单已评价');
            }
            $satisfaction_value = explode('%', $satisfaction)[0];
            if($satisfaction_value < 100) {
                $calcul = bcdiv($satisfaction_value, 1000, 2);
                $refund = bcsub($item->satisfied_fees, bcmul($item->satisfied_fees, $calcul, 2), 2);
                $available_money = UserModel::where('id', $item->gid)->first()->availablemoney;
                if($available_money > $refund) {
                    $this->capitalModel::create([
                        'uid' => $this->userId,
                        'order_id' => $item->order_id,
                        'money' => $refund,
                        'trade_mode' => $item->order->pay_method,
                        'memo' => '满意度评价返回金额',
                        'category' => 400,
                        'g_order_id' => $item->id,
                        'status' => 1001
                    ]);
                    $this->capitalModel::create([
                        'uid' => $item->gid,
                        'order_id' => $item->order_id,
                        'money' => '-'. $refund,
                        'trade_mode' => $item->order->pay_method,
                        'memo' => '满意度评价返回给用户金额',
                        'category' => 500,
                        'g_order_id' => $item->id,
                        'status' => 1001
                    ]);
                }
            }
            $this->evaluationModel::create([
                'sid' => $item->sid,
                'uid' => $this->userId,
                'satisfaction' => $satisfaction_value,
                'goods_evaluation' => $request->goods_evaluation,
                'service_evaluation' => $request->service_evaluation,
                'anonymous' => $request->anonymous == true ? 1 : 0,
                'order_id' => $item->id,
                'images' => !empty($request->images) ? json_encode($request->images) : ''
            ]);
            $item->status = 600;
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
     * 订单支付
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function pay($id, PersonalHaveGoodsService $service)
    {
        try {
            $result = $service->pay($id);
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
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }

    /**
     * 回调
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function notify(PersonalHaveGoodsService $service)
    {
        try {
            $result = $service->notify();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
        return $result;
    }
}
