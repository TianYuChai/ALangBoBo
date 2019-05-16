<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/16
 * Time: 16:22
 */
namespace App\Console\Commands;

use App\Http\Models\currency\CapitalModel;
use Illuminate\Console\Command;

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

    }
}
