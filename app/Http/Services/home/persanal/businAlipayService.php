<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/14
 * Time: 15:28
 */
namespace App\Http\Services\home\persanal;

use App\Http\Models\currency\CapitalModel;
use App\Http\Models\currency\MerchantModel;
use App\Http\Models\setup\SettledModel;
use App\Http\Services\home\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Yansongda\Pay\Pay;

class businAlipayService extends BaseService
{
    protected $capitalmode;
    protected $config;
    protected $settledmode;

    public function __construct(CapitalModel $capitalModel, SettledModel $settledModel)
    {
        parent::__construct();
        $this->capitalmode = $capitalModel;
        $this->settledmode = $settledModel;
        $this->config = config('alipay.pay');
    }

    public function entrance($data)
    {
        $order_id = create_order_no();
        $item = $this->capitalmode::create([
            'uid' => $this->userId,
            'order_id' => $order_id,
            'money' => $data->moneys,
            'trade_mode' => 'Alipay',
            'memo' => '入驻费',
            'category' => 600,
            'status' => 1002
        ]);
        $order = [
            'out_trade_no' => $item->order_id,
            'total_amount' => $item->money,
            'passback_params' => urlencode($this->userId .'-'. $data->duration),
            'subject' => '阿郎博波商务中心',
            'body' => '入驻费充值',
        ];
        $this->config['notify_url'] = route('index.busin.notify');
        $this->config['return_url'] = route('personal.businresidfee');
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
        Log::info('入驻费---支付宝异步回调处理-------start');
        $data = $vailet->all();
        if($data['trade_status'] == 'TRADE_SUCCESS' || $data['trade_status'] == 'TRADE_FINISHED'
            && $data['app_id'] == $this->config['app_id']) {
            $item = $this->capitalmode::where([
                'order_id' => strval($data['out_trade_no']),
                'money' => $data['receipt_amount'],
                'category' => 600,
                'status' => 1002
            ])->first();
            if($item) {
                $item->status = 1003;
                $item->trans_at = getTime();
                $item->save();
                $user_reghare = explode('-', $data['passback_params']);
                $merchant = MerchantModel::where('uid', intval($user_reghare[0]))->first();
                if($merchant) {
                    $time = strtotime($merchant->due_at) == false ? Carbon::now() : Carbon::parse($merchant->due_at);
                    $merchant->due_at = $time->modify('+'.intval($user_reghare[1]).' days')->toDateTimeString();
                    Log::info('时间'. $merchant->due_at .'------' . $time . '----------'. $time->modify('+'.intval($user_reghare[1]).' days')->toDateTimeString());
                    Log::info('1', $merchant->toArray());
                    $merchant->save();
                }
            }
            Log::info('入驻费---支付宝异步回调处理----------end');
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
}
