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
use Log;
use Yansongda\Pay\Pay;

class demand extends Command
{
    /**
     * The name and signature of the console command.The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '处理需求';

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
            $this->model::where('status', 302)->where('timeout', '<=', getTime())->update(['status' => 301]);
        } catch (Exception $e) {
            Log::info('处理待支付需求:', [
                'time' => getTime(),
                'info' => $e->getMessage(),
            ]);
        }
    }
}
