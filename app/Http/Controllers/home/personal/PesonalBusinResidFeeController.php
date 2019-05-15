<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/5/15
 * Time: 20:41
 */
namespace App\Http\Controllers\home\personal;

use App\Http\Controllers\home\BaseController;
use App\Http\Models\currency\CapitalModel;
use App\Http\Models\setup\SettledModel;
use App\Http\Services\home\persanal\businAlipayService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class PesonalBusinResidFeeController extends BaseController
{
    const ROUTE = HOME_PERSONAL;
    protected $capitalModel;
    protected $settledModel;

    public function __construct(SettledModel $settledModel, CapitalModel $capitalModel)
    {
        $this->middleware(function ($request, $next) use ($settledModel, $capitalModel){
            if(Auth::guard('web')->check()) {
                $this->userId = Auth::guard('web')->user()->id;
            }
            $this->capitalModel = $capitalModel;
            $this->settledModel = $settledModel;
            return $next($request);
        });
    }

    /**
     * 年费
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $items = $this->capitalModel::where([
            'uid' => $this->userId,
            'category' => 600,
        ])->orderBy('id', 'desc')->get();
        $recharge_options = $this->settledModel::orderBy('sort', 'desc')->get();
        $data = [
            'items' => $items,
            'recharge_options' => $recharge_options
        ];
        return view(self::ROUTE . 'businResidFee', compact('data'));
    }

    /**
     * 支付
     * 
     * @param Request $request
     * @param businAlipayService $alipayService
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function pay(Request $request, businAlipayService $alipayService)
    {
        try {
            $method = trim($request->input('method', ''));
            $recharge = trim($request->recharge);
            $item = $this->settledModel::where('id', intval($recharge))->first();
            if(!$item) {
                throw new Exception('请重新选择支付');
            }
            if($method == 'Alipay') {
                $result = $alipayService->entrance($item);
            } else if($method == 'WeChat') {

            } else {
                throw new Exception('类别错误');
            }
            return $result;
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }

    /**
     * 异步回调
     *
     * @param AlipayService $alipayService
     * @return mixed
     */
    public function notify(businAlipayService $alipayService)
    {
        try {
            $result = $alipayService->notify();
        } catch (Exception $e) {
            Log::info('支付宝异步回调错误:' . $e->getMessage());
        }
        return $result;
    }
}