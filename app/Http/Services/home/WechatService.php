<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/20
 * Time: 11:37
 */
namespace App\Http\Services\home;

use App\Http\Models\currency\CapitalModel;
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
//        $item = $this->capitalmode::create([
//            'uid' => $this->userId,
//            'order_id' => $order_id,
//            'money' => $data['money'],
//            'trade_mode' => 'Wechat',
//            'memo' => '保证金充值',
//            'category' => 300,
//            'status' => 1002
//        ]);
            $order = [
                'out_trade_no' => $order_id,
                'total_fee' => bcmul('0.01', 100),
                'body' => '保证金充值',
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
        Log::info('保证金---微信异步回调处理', [
            'data' => $data
        ]);
        return $vailet->success();
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
