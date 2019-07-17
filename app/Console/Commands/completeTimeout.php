<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/16
 * Time: 16:22
 */
namespace App\Console\Commands;

use App\Http\Models\currency\CapitalModel;
use App\Http\Models\home\evaluationModel;
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
        $this->capitalModel = CapitalModel::class;
        $this->evaluationModel = evaluationModel::class;
    }

    /**
     * 用户生成订单情况下未进行相关支付操作。再一段时间后进行关闭订单操作
     */
    public function handle()
    {
        try {
            $items = $this->shoppOrderModel::where('status', 500)->where('signtime', '<', getTime())->get();
            foreach ($items as $item) {
                $this->capitalModel::create([
                    'uid' => $item->gid,
                    'order_id' => $item->order_id,
                    'money' => $item->satisfied_fees,
                    'trade_mode' => isset($item->order) ? $item->order->pay_method : 'Alipay',
                    'memo' => '满意度评价金额',
                    'category' => 500,
                    'g_order_id' => $item->id,
                    'status' => 1001
                ]);
                $this->evaluationModel::create([
                    'sid' => $item->sid,
                    'uid' => $item->uid,
                    'satisfaction' => 100,
                    'goods_evaluation' => '自动评价',
                    'service_evaluation' => '自动评价',
                    'anonymous' => 1,
                    'order_id' => $item->id,
                    'images' => ''
                ]);
                $item->status = 600;
                $item->save();
            }
        } catch (Exception $e) {
            Log::info('订单签收后到时评价:', [
                'time' => getTime(),
                'info' => $e->getMessage(),
            ]);
        }
    }
}
