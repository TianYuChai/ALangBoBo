<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/16
 * Time: 16:22
 */
namespace App\Console\Commands;

use App\Http\Models\currency\CapitalModel;
use App\Http\Models\home\demandModel;
use App\Http\Models\home\shoppOrderModel;
use Illuminate\Console\Command;
use Exception;
use Illuminate\Support\Facades\DB;
use Log;
use Yansongda\Pay\Pay;

class demand_wait extends Command
{
    /**
     * The name and signature of the console command.The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demand_wait';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '处理等待需求';

    public function __construct()
    {
        parent::__construct();
        $this->model = demandModel::class;
        $this->capitalModel = CapitalModel::class;
        $this->config = config('alipay.pay');
    }


    public function handle()
    {
        try {
            DB::beginTransaction();
            $items = $this->model::where('status', 303)->where('timeout', '<=', getTime())->get();
            if(!$items->isEmpty()) {
                foreach ($items as $item) {
                    $item->status = 307;
                    $item->save();
                    if($item->pay_method == 'Alipay') {
                        $order = [
                            'out_trade_no' => $item->order_id,
                            'refund_amount' => $item->moneys,
                            'out_request_no' => $item->id,
                            'refund_reason' => '订单退款'
                        ];
                        $alipay = Pay::alipay($this->config)->refund($order);
                        if($alipay['msg'] == 'Success') {
                            $item->status = 308;
                            $item->save();
                            CapitalModel::where([
                                'status' => 1003,
                                'category' => 100,
                                'uid' => $item->uid,
                                'order_id' => $item->order_id
                            ])->update(['status' => 1002]);
                        }
                    } else {

                    }
                }
                DB::commit();
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('处理等待接单需求:', [
                'time' => getTime(),
                'info' => $e->getMessage(),
            ]);
        }
    }
}
