<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/14
 * Time: 15:28
 */
namespace App\Http\Services\home;

use App\Http\Models\currency\CapitalModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yansongda\Pay\Pay;

class AlipayService extends BaseService
{
    protected $capitalmode;
    protected $config;
    public function __construct(CapitalModel $capitalModel)
    {
        parent::__construct();
        $this->capitalmode = $capitalModel;
        $this->config = config('alipay.pay');
    }

    public function entrance($money)
    {
        $order_id = create_order_no();
        $item = $this->capitalmode::create([
            'uid' => $this->userId,
            'order_id' => $order_id,
            'money' => $money,
            'trade_mode' => 'Alipay',
            'memo' => '保证金',
            'category' => 300,
            'status' => 1002
        ]);
        $order = [
            'out_trade_no' => $item->order_id,
            'total_amount' => $item->money,
            'subject' => '阿郎博波商务中心',
            'body' => '保证金充值',
        ];
        $this->config['notify_url'] = route('index.alipay.notify');
        $this->config['return_url'] = route('personal.creditmargin');
        $alipay = Pay::alipay($this->config)->web($order);
        return $alipay;
    }

    /**
     * 异步回调地址
     *
     * @return mixed
     */
    public function notify()
    {
        $vailet = $this->vailet();
        Log::info('保证金---支付宝异步回调处理-------start');
        $data = $vailet->all();
        if($data['trade_status'] == 'TRADE_SUCCESS' || $data['trade_status'] == 'TRADE_FINISHED'
            && $data['app_id'] == $this->config['app_id']) {
            $item = $this->capitalmode::where([
                'order_id' => strval($data['out_trade_no']),
                'category' => 300,
                'status' => 1002
            ])->first();
            Log::info('订单：'.strval($data['out_trade_no']).'执行中');
            if($item) {
                $item->status = 1003;
                $item->trans_at = getTime();
                $item->due_at = Carbon::now()->modify('+30 days')->toDateTimeString();
                $item->save();
            }
            Log::info('保证金---支付宝异步回调处理----------end');
        }
        return Pay::alipay($this->config)->success();
    }

    /**
     * 验签
     *
     * @return mixed
     */
    public function vailet()
    {
        return Pay::alipay($this->config)->verify();
    }

    /**
     * @支付宝提现
     * @param $money
     * @param $procedures_fee
     * @param $account
     * @return \Yansongda\Supports\Collection
     */
    public function cashWith($money, $procedures_fee, $account)
    {
        $order_id = create_order_no();
        $item = $this->capitalmode::create([
            'uid' => $this->userId,
            'order_id' => $order_id,
            'money' => '-'. bcadd($money, $procedures_fee),
            'trade_mode' => 'Alipay',
            'memo' => '提现, 站方收取手续费金额：'. $procedures_fee.'元，提现账户为:'. $account,
            'category' => 200,
            'status' => 1002
        ]);
        $order = [
            'out_biz_no' => $item->order_id,
            'payee_type' => "ALIPAY_LOGONID",
            'payee_account' => $account,
            'amount' => $money,
            'remark' => '阿郎博波转账',
        ];
        $alipay = Pay::alipay($this->config)->transfer($order);
        return $alipay;
    }
}
