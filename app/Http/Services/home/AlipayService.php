<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/14
 * Time: 15:28
 */
namespace App\Http\Services\home;

use App\Http\Models\currency\CapitalModel;
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
            'subject' => '阿郎博波保证金充值',
        ];
        $this->config['notify_url'] = route('index.alipay.notify');
        $this->config['return_url'] = route('index.alipay.returnurl');
        $alipay = Pay::alipay(config('alipay.pay'))->web($order);
        return $alipay;
    }

    /**
     * 异步回调地址
     *
     * @return mixed
     */
    public function notify()
    {
        $data = $this->vailet();
        Log::debug('Alipay notify', $data->all());
        return $data->success()->send();
    }

    /**
     * 验签
     *
     * @return mixed
     */
    public function vailet()
    {
        return Pay::alipay(config('alipay.pay'))->verify();
    }
}
