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
        $alipay = Pay::alipay($this->config);
            try{
                $data = $alipay->verify(); // 是的，验签就这么简单！
                // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
                // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
                // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
                // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
                // 4、验证app_id是否为该商户本身。
                // 5、其它业务逻辑情况
                Log::debug('Alipay notify', $data->all());
            } catch (\Exception $e) {
                // $e->getMessage();
            }
        return $alipay->success();// laravel 框架中请直接 `return $alipay->success()`
//        $data = $this->vailet();
//        Log::info('Alipay notify', $data->all());
//        return $data->success();
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
