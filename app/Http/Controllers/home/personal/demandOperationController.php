<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/14
 * Time: 16:55
 */
namespace App\Http\Controllers\home\personal;

use App\Http\Controllers\home\BaseController;
use App\Http\Models\home\demandModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Exception;

class demandOperationController extends BaseController
{
    const ROUTE = HOME_PERSONAL;

    public function __construct(demandModel $model)
    {
        $this->middleware(function ($request, $next) use ($model){
            $this->user = Auth::guard('web')->user();
            $this->model = $model;
            return $next($request);
        });
    }

    public function index()
    {
        $status = Input::get('status', '');
        $title = trim(Input::get('title', ''));
        $items = $this->model::where('uid', $this->user->id)
                                ->SearchStatus($status)
                                ->SearchTitle($title)
                                ->orderBy('updated_at', 'desc')
                                ->paginate(parent::$page_limit);
        return view(self::ROUTE . 'demands', compact('items'));
    }

    /**
     * 删除
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function del($id)
    {
        try {
            $this->model::where([
                'status' => 302,
                'uid' => $this->user->id,
                'id' => intval($id)
            ])->delete();
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }

    /**
     * 添加并支付
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $title = trim($request->title);
            if(empty($title)) {
                throw new Exception('请填写需求名称, 方便您的需求被人快速查找');
            }
            $display = $request->display;
            $display_array = demandModel::$_DISPLAY;
            if(!in_array(array_get($display_array, $display), $display_array)) {
                throw new Exception('请选择正确的表现形式');
            }
            $material = $request->material;
            $material_array = demandModel::$_MATERIAL;
            if(!in_array(array_get($material_array, $material), $material_array)) {
                throw new Exception('请选择正确的材料');
            }
            $time = $request->time;
            if (empty($time)) {
                throw new Exception('请填写工期');
            }
            $cost = trim($request->cost);
            if(empty($cost)) {
                throw new Exception('请填入成本');
            }
            $refund_timeout = trim($request->refund_timeout);
            if(empty($refund_timeout)) {
                throw new Exception('请填入上架时长');
            }
            if($refund_timeout < 0 || $refund_timeout > 30) {
                throw new Exception('请填入正确的上架时长');
            }
            $describe = trim($request->describe);
            if(empty($describe)) {
                throw new Exception('请填入描述');
            }
            $img = trim($request->img);
            if(empty($img)) {
                throw new Exception('请上传图片');
            }
            $cost_price = bcmul($cost, 100);
            $statisfaction_price = !empty($request->satisfaction) ? bcmul($request->satisfaction, 100) : 0;
            $money = bcadd($cost_price, $statisfaction_price, 2);
            $pay_method = $request->pay_method;
            $item = $this->model::create([
                'title' => $title,
                'uid' => $this->user->id,
                'describe' => $describe,
                'money' => intval($money),
                'cost' => intval($cost_price),
                'satisfaction' => intval($statisfaction_price),
                'poundage' => intval(bcmul($money, 0.1)),
                'display' => $display,
                'material' => $material,
                'time' => $time,
                'other' => !empty($request->other) ? trim($request->other) : '',
                'img' =>  $img,
                'content' => !empty($request->input('content')) ? $request->input('content') : '',
                'timeout' => Carbon::now()->modify('+1 days')->toDateTimeString(),
                'refund_timeout' => intval($refund_timeout),
                'status' => 302,
                'pay_method' => $pay_method,
                'order_id' => create_order_no()
            ]);
            return $this->pay($item, $pay_method);
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }

    public function pay($data, $pay_method)
    {
        $cofig = config('alipay.pay');
        try {
            if($pay_method == 'Alipay') {
                $order = [
                    'out_trade_no' => $data->order_id,
                    'total_amount' => '0.05',
                    'subject' => '阿郎博波商务中心',
                    'body' => '百录倩影—需求支付',
                ];
                $cofig['notify_url'] = route('index.demand.alinotify');
                $cofig['return_url'] = route('personal.creditmargin');
                $alipay = Pay::alipay($cofig)->web($order);
                return $alipay;
            } else if($pay_method == 'WeChat') {

            } else {
                throw new Exception('支付方式错误');
            }
        } catch (Exception $e) {
            Log::info('需求支付', [
                'time' => getTime(),
                'info' => $e->getMessage()
            ]);
            throw new Exception('请联系管理员');
        }
    }

    /**
     * 支付宝支付回调
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function aliNotify()
    {
        try {
            $cofig = config('alipay.pay');
            $vailet = Pay::alipay($cofig)->verify();
            $data = $vailet->all();
            if($data['trade_status'] == 'TRADE_SUCCESS' || $data['trade_status'] == 'TRADE_FINISHED'
                && $data['app_id'] == $cofig['app_id']) {
                $item = demandModel::where([
                    'order_id' => strval($data['out_trade_no']),
                    'status' => 302
                ])->first();
                $item->status = 303;
                $item->timeout = Carbon::now()->modify('+'.$item->refund_timeout.' days')->toDateTimeString();
                $item->save();
                CapitalModel::create([
                    'uid' => $item->uid,
                    'order_id' => $item->order_id,
                    'money' => $item->money,
                    'trade_mode' => $item->pay_method,
                    'memo' => '需求支付',
                    'category' => 100,
                    'g_order_id' => '',
                    'status' => 1003
                ]);
                Log::info('订单支付宝异步回调处理结束', [
                    'info' => '需求',
                    'order_id' => $data['out_trade_no']
                ]);
            }
            return Pay::alipay($this->config)->success();
        } catch (Exception $e) {
            Log::info('支付宝支付回调:', [
                'time' => getTime(),
                'info' => $e->getMessage()
            ]);
        }
    }
}
