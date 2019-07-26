<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/7/26
 * Time: 10:31
 */
namespace App\Console\Commands;

use App\Http\Models\home\shoppOrderModel;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class orderSmsNotice extends Command
{
    /**
     * The name and signature of the console command.The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order_sms_notice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '认缴订单到期前2天, 短信通知支付';


    public function handle()
    {
        $time = Carbon::createFromFormat('Y-m-d', date('Y-m-d', time()))->modify('+2 days');
        $time_range = [$time->copy()->startOfDay()->toDateTimeString(), $time->copy()->endOfDay()->toDateTimeString()];
        $order_uids = shoppOrderModel::whereBetween('timeout', $time_range)
                                    ->where('pay_method', 'subscribed')->groupBy(['uid'])->get()->pluck('uid');
        if(!empty($order_uids)) {
            foreach ($order_uids as $uid) {
                if(!Cache::has('order:sms:notice:'. $uid)) {
                    \App\Jobs\orderSmSNotice::dispatch($uid);
                }
            }
        }
    }
}
