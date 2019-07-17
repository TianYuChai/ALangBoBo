<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/16
 * Time: 16:22
 */
namespace App\Console\Commands;

use App\Http\Models\currency\CapitalModel;
use App\Http\Models\home\shoppOrderModel;
use Illuminate\Console\Command;
use Exception;
use Log;

class credit extends Command
{
    /**
     * The name and signature of the console command.The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'credit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '用于保证金解冻';

    public function __construct()
    {
        parent::__construct();
        $this->model = CapitalModel::class;
        $this->shoppOrderModel = shoppOrderModel::class;
    }

    /**
     * 解冻保证金
     * 在状态为300的情况下
     *
     * 并且状态为1003和解冻时间到达
     *
     * 订单认缴模式都支付完成的情况下才可解冻
     *
     */
    public function handle()
    {
        try {
            $items = $this->model::where([
                'category' => 300,
                'status' => 1003,
            ])->where('due_at', '<', getTime())
              ->where('due_at', '<>', '')
              ->where('due_at', '<>', '0000-00-00 00:00:00')->get();
            $orders = $this->shoppOrderModel::whereIn('uid', $items->pluck('uid'))
                ->where('pay_method', 'subscribed')
                ->where('timeout', '<>', '0000-00-00 00:00:00')
                ->groupBy('uid')->get()->toArray();
            foreach ($items as $item) {
                if(!isset($orders[$item->uid])) {
                    $item->status = 1001;
                    $item->save();
                }
            }
        } catch (Exception $e) {
            Log::info('解冻保证金:', [
                'time' => getTime(),
                'info' => $e->getMessage(),
            ]);
        }
    }
}
