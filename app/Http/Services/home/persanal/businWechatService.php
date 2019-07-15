<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/21
 * Time: 14:34
 */
namespace App\Http\Services\home\persanal;

use App\Http\Models\currency\CapitalModel;
use App\Http\Models\currency\MerchantModel;
use App\Http\Models\setup\SettledModel;
use App\Http\Services\home\BaseService;
use Carbon\Carbon;
use Yansongda\Pay\Pay;
use Log;

class businWechatService extends BaseService
{
    public function __construct(CapitalModel $capitalModel, SettledModel $settledModel)
    {
        parent::__construct();
        $this->capitalmode = $capitalModel;
        $this->settledmode = $settledModel;
        $this->config = config('wechat.pay');
    }

    public function entrance($data)
    {
        $order_id = create_order_no();
        $item = $this->capitalmode::create([
            'uid' => $this->userId,
            'order_id' => $order_id,
            'money' => $data->moneys,
            'trade_mode' => 'WeChat',
            'memo' => '入驻费充值',
            'category' => 600,
            'status' => 1002
        ]);
        $order = [
            'out_trade_no' => $item->order_id,
            'total_fee' => bcmul($data->moneys, 100),
            'attach' => urlencode($this->userId .'-'. $data->duration),
            'body' => '阿郎博波商务中心---保证金充值',
        ];
        $this->config['notify_url'] = route('index.busin.wxnotify');
        $wechat = Pay::wechat($this->config)->scan($order);
        return $wechat['code_url'];
    }

    /**
     * 异步回调地址
     *
     * @return mixed
     */
    public function notify()
    {
        $vailet = $this->vailet();
        Log::info('入驻费---微信异步回调处理-------start');
        $data = $vailet->all();
        Log::info('微信入驻费返回参数', [
            'data' => $data
        ]);
        if($data['return_code'] == 'SUCCESS' || $data['result_code'] == 'SUCCESS'
            && $data['app_id'] == $this->config['app_id']) {
            $item = $this->capitalmode::where([
                'order_id' => strval($data['out_trade_no']),
                'category' => 600,
                'status' => 1002
            ])->first();
            if($item) {
                $item->status = 1003;
                $item->trans_at = getTime();
                $item->save();
                $user_reghare = explode('-', $data['attach']);
                $merchant = MerchantModel::where('uid', intval($user_reghare[0]))->first();
                if($merchant) {
                    $time = $merchant->due_at == "0000-00-00 00:00:00" || $merchant->due_at == ''
                        ? Carbon::now() : Carbon::parse($merchant->due_at);
                    $merchant->due_at = $time->modify('+'.intval($user_reghare[1]).' days')->toDateTimeString();
                    $merchant->save();
                }
            }
            Log::info('入驻费---微信异步回调处理----------end');
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
}
