<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/13
 * Time: 10:16
 */
namespace App\Http\Controllers\home\personal;

use App\Http\Controllers\home\BaseController;
use App\Http\Models\currency\CapitalModel;
use App\Http\Models\setup\SettledModel;
use App\Http\Services\home\AlipayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use Log;

class PersonalCreditMarginController extends BaseController
{
    const ROUTE = HOME_PERSONAL; //视图路径
    protected $model;
    protected $capitalModel;
    protected $userId;

    public function __construct(SettledModel $model, CapitalModel $capitalModel)
    {
        $this->middleware(function ($request, $next) use ($model, $capitalModel){
            if(Auth::guard('web')->check()) {
                $this->userId = Auth::guard('web')->user()->id;
            }
            $this->model = $model;
            $this->capitalModel = $capitalModel;
            return $next($request);
        });
    }

    /**
     * 保证金
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $query = $this->capitalModel::where([
            'uid' => $this->userId,
            'category' => 300,
        ]);
        $items = $query->orderBy('id', 'desc')->get();
        $grouping = $query->select('status', DB::raw('sum(money) as price'))->groupBy('status')->get();
        $data = [
            'items' => $items,
            'group_message' => $grouping
        ];
        return view(self::ROUTE . 'creditMargin', compact('data'));
    }

    public function pay(Request $request, AlipayService $alipayService)
    {
        try {
            $money = trim($request->money);
            $method = trim($request->input('method'));
            if(!$money) {
                throw new Exception('请填入充值金额');
            }
            if(!regularHaveSinoram($money)) {
                throw new Exception('支付金额包含中文');
            }
            if(!preg_match('/^[0-9]+(.[0-9]{1,2})?$/', $money)) {
                throw new Exception('支付金额类型错误');
            }
            if($money < 100) {
                throw new Exception('保证金充值需大于100元');
            }
            if($method == 'Alipay') {
                $money = 0.01;
                $result = $alipayService->entrance($money);
            } else if($method == 'WeChat'){

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
    public function notify(AlipayService $alipayService)
    {
        try {
            $result = $alipayService->notify();
        } catch (Exception $e) {
            Log::info('支付宝异步回调错误:' . $e->getMessage());
        }
        return $result;
    }
}
