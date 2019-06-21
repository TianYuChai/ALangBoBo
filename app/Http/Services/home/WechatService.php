<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/20
 * Time: 11:37
 */
namespace App\Http\Services\home;

use App\Http\Models\currency\CapitalModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yansongda\Pay\Pay;
use Exception;
use Log;

class WechatService extends BaseService
{
    public function __construct(CapitalModel $capitalModel)
    {
        parent::__construct();
        $this->capitalmode = $capitalModel;
        $this->config = config('wechat.pay');
    }

    public function entrance($money)
    {
        try {
            $order_id = create_order_no();
            $item = $this->capitalmode::create([
                'uid' => $this->userId,
                'order_id' => $order_id,
                'money' => $money,
                'trade_mode' => 'Wechat',
                'memo' => '保证金充值',
                'category' => 300,
                'status' => 1002
            ]);
            $order = [
                'out_trade_no' => $item->order_id,
                'total_fee' => bcmul('0.01', 100),
                'body' => '阿朗博博商务中心---保证金充值',
            ];
            $this->config['notify_url'] = route('index.wx.notify');
            $wechat = Pay::wechat($this->config)->scan($order);
            return $wechat['code_url'];
        } catch (Exception $e) {
            Log::info('微信保证金支付: ', [
               'time' => getTime(),
               'info' => $e->getMessage()
            ]);
            throw new Exception('支付异常, 请联系管理员');
        }
    }

    /**
     * 异步回调
     *
     * @return mixed
     */
    public function notify()
    {
        $vailet = $this->vailet();
        $data = $vailet->all();
        if($data['return_code'] == 'SUCCESS' || $data['result_code'] == 'SUCCESS'
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
            Log::info('保证金---微信异步回调处理结束');
        }
        return Pay::wechat($this->config)->success();
    }

    /**
     * 验签
     *
     * @return mixed
     */
    public function vailet()
    {
        return Pay::wechat($this->config)->verify();
    }

    /**
     * 微信提现
     *
     * @param $money
     * @param $procedures_fee
     * @param $account
     * @return bool
     */
    public function cashWith($money, $procedures_fee, $account)
    {
        $order_id = create_order_no();
        $item = $this->capitalmode::create([
            'uid' => $this->userId,
            'order_id' => $order_id,
            'money' => '-'. bcadd($money, $procedures_fee, 2),
            'trade_mode' => 'WeChat',
            'memo' => '余额提现, 站方收取手续费金额：'. $procedures_fee.'元，提现账户为:'. $account,
            'category' => 200,
            'status' => 1002
        ]);
        $order = [
            'partner_trade_no' => $item->order_id,              //商户订单号
            'openid' => '',                        //收款人的openid
            'check_name' => 'FORCE_CHECK',            //NO_CHECK：不校验真实姓名\FORCE_CHECK：强校验真实姓名
            're_user_name'=> $account,              //check_name为 FORCE_CHECK 校验实名的时候必须提交
            'amount' => bcmul($money, 100),                       //企业付款金额，单位为分
            'desc' => '帐户提现',                  //付款说明
        ];
        $wechat = Pay::wechat($this->config)->transfer($order);
        dd($wechat);
//        if($alipay['msg'] == 'Success') {
//            $this->capitalmode::where('order_id', $alipay['out_biz_no'])->update(['status' => 1001]);
//        }
//        return true;
    }
}
