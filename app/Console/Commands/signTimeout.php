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
use Carbon\Carbon;
use Illuminate\Console\Command;
use Exception;
use Log;

class signTimeout extends Command
{
    /**
     * The name and signature of the console command.The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sign_timeout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '订单指定时间内完成签收';

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
            $this->shoppOrderModel::where('status', 400)
                                    ->where('signtime', '<', getTime())->update([
                    'status' => 500,
                    'signtime' => Carbon::now()->modify('+7 days')->toDateTimeString()
                ]);
        } catch (Exception $e) {
            Log::info('订单超时签收:', [
                'time' => getTime(),
                'info' => $e->getMessage(),
            ]);
        }
    }
}
