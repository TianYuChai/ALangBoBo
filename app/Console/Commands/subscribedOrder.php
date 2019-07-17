<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/16
 * Time: 16:22
 */
namespace App\Console\Commands;

use App\Http\Models\currency\CapitalModel;
use App\Http\Models\currency\UserModel;
use App\Http\Models\home\orderModel;
use App\Http\Models\home\shoppOrderModel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Exception;
use Log;

class subscribedOrder extends Command
{
    /**
     * The name and signature of the console command.The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscribed_order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '认缴订单超时未支付处理';

    public function __construct()
    {
        parent::__construct();
        $this->model = orderModel::class;
        $this->shoppOrderModel = shoppOrderModel::class;
    }

    /**
     * 认缴订单超时未支付处理
     */
    public function handle()
    {
        try {
           $items = $this->shoppOrderModel::where('pay_method', 'subscribed')
                                            ->whereIn('status', [300, 400, 500, 600])
                                            ->where('timeout', '!=', '0000-00-00 00:00:00')
                                            ->where('timeout', '!=', '')
                                            ->where('timeout', '<', getTime())
                                            ->get();
           foreach ($items as $item) {
               $user = UserModel::where('id', $item->uid)->first();
               if($item->moneys < $user->frozen_capital) {
                   if($item->status < 600) {
                       $moneys = bcsub($item->moneys, bcmul($item->satisfiedfees, $item->num, 2), 2);
                   } else {
                       $moneys = $item->moneys;
                   }
                   CapitalModel::create([
                       'uid' => $item->gid,
                       'order_id' => $item->order_id,
                       'g_order_id' => $item->id,
                       'money' => $moneys,
                       'trade_mode' => $item->pay_method,
                       'memo' => '用户备注:' . empty($item->memo) ? '无, 平台备注: 买家未付款，保证金赔付' :
                           $item->memo. ','. '平台备注: 买家未付款，保证金赔付',
                       'category' => 500,
                       'status' => 1001,
                       'trans_at' => $item->created_at,
                   ]);
                   $item->timeout = '';
                   $item->save();
                   CapitalModel::create([
                       'uid' => $user->id,
                       'order_id' => $item->order_id,
                       'money' => '-' . $item->moneys,
                       'trade_mode' => '',
                       'category' => 300,
                       'g_order_id' => $item->id,
                       'status' => 1003,
                       'memo' => '平台备注: 订单未付款，保证金赔付',
                   ]);
               }
           }
           Log::info('认缴订单超时未支付处理完成');
        } catch (Exception $e) {
            Log::info('认缴订单超时未支付处理:', [
                'time' => getTime(),
                'info' => $e->getMessage(),
            ]);
        }
    }
}
