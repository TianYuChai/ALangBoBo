<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/16
 * Time: 16:22
 */
namespace App\Console\Commands;

use App\Http\Models\home\orderModel;
use App\Http\Models\home\shoppOrderModel;
use Illuminate\Console\Command;
use Exception;
use Log;

class orderTimeoutDown extends Command
{
    /**
     * The name and signature of the console command.The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order_timeout_down';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '订单未支付状态下超时间关闭';

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
            $items = $this->model::where('status', 2001)
                                    ->where('timeout', '<', getTime())->get(['order_id']);
            $this->shoppOrderModel::whereIn('order_id', $items->pluck('order_id')->toArray())
                                    ->where('status', 200)->update(['status' => 100]);
        } catch (Exception $e) {
            Log::info('订单超时关闭:', [
                'time' => getTime(),
                'info' => $e->getMessage(),
            ]);
        }
    }
}
