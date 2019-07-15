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

class demand_complete extends Command
{
    /**
     * The name and signature of the console command.The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demand_complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '处理收货等待完成需求';

    public function __construct()
    {
        parent::__construct();
        $this->model = demandModel::class;
        $this->capitalModel = CapitalModel::class;
        $this->config = config('alipay.pay');
    }


    public function handle()
    {
        DB::beginTransaction();
        try {
            $items = $this->model::where('status', 305)->where('timeout', '<=', getTime())->get();
            if(!$items->isEmpty()) {
                foreach ($items as $item) {
                    $item->status = 306;
                    $item->save();
                    $capital = $this->capitalModel::where([
                        'status' => 1003,
                        'category' => 100,
                        'order_id' => $item->order_id,
                        'uid' => $item->uid
                    ])->first()->update([
                        'category' => 400,
                        'status' => 1004,
                        'memo' => '支付完成'
                    ]);
                    CapitalModel::create([
                        'uid' => $item->gid,
                        'order_id' => $item->order_id,
                        'money' => $item->moneys - $item->poundageprice,
                        'trade_mode' => $item->pay_method,
                        'memo' => '总金额: '.$item->moneys.', 收到金额: '.$item->moneys - $item->poundageprice.', 扣除平台手续费: '. $item->poundageprice. '评价金额:'.$item->satisfaction_price,
                        'category' => 500,
                        'g_order_id' => '',
                        'status' => 1001
                    ]);
                }
                DB::commit();
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('处理收货等待完成需求:', [
                'time' => getTime(),
                'info' => $e->getMessage(),
            ]);
        }
    }
}
