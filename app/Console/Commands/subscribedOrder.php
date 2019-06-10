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
     * 用户生成订单情况下未进行相关支付操作。再一段时间后进行关闭订单操作
     */
    public function handle()
    {
        try {
           $items = $this->shoppOrderModel::where('pay_method', 'subscribed')
                                            ->whereIn('status', [300, 400, 500, 600])
                                            ->where('timeout', '<', getTime())
                                            ->get();
           $capitals = CapitalModel::whereIn('g_order_id', $items->pluck('id')->toArray())->get();
           foreach ($items as $item) {
               $user = UserModel::where('id', $item->uid)->first();
               if($item->moneys < $user->frozen_capital) {
                   $capital = $capitals->where('g_order_id', $item->id)->first();
                   $capital->status = 1001;
                   $capital->save();
                   $item->timeout = '';
                   $item->save();
                   CapitalModel::create([
                       'uid' => $user->id,
                       'order_id' => $item->order_id,
                       'money' => '-' . $item->moneys,
                       'trade_mode' => '',
                       'category' => 300,
                       'g_order_id' => $item->id,
                       'status' => 1003
                   ]);
               }
           }
        } catch (Exception $e) {
            Log::info('认缴订单超时未支付处理:', [
                'time' => getTime(),
                'info' => $e->getMessage(),
            ]);
        }
    }
}
