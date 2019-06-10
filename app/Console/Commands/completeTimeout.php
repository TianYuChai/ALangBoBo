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

class completeTimeout extends Command
{
    /**
     * The name and signature of the console command.The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order_complete_timeout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '订单签收后到时评价';

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
            $this->shoppOrderModel::where('status', 500)->where('signtime', '<', getTime())->update([
               'status' => 600
            ]);
        } catch (Exception $e) {
            Log::info('订单签收后到时评价:', [
                'time' => getTime(),
                'info' => $e->getMessage(),
            ]);
        }
    }
}
