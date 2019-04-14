<?php

namespace App\Console\Commands;

use App\Http\Models\admin\goods\BannerModel;
use Illuminate\Console\Command;

class Banner extends Command
{
    /**
     * The name and signature of the console command.The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'banner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '用于首页轮播的上下架操作';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = BannerModel::class;
    }

    /**
     * Execute the console command.
     * 执行指定日期的轮播图进行上下架操作
     * 1.把未上架的轮播图进行上架
     * 2.把已上架的轮播图进下架
     * 执行条件，到达执行日期
     * @return mixed
     */
    public function handle()
    {
        $this->model::where(function ($query) {
            $query->where([
                'start_time' => getTime('ymd'),
                'status' => 0
            ]);
        })->update([
            'status' => 1
        ]);
        $this->model::where(function ($query) {
            $query->where('end_time', '<=', getTime('ymd'))
                    ->where('status', 1);
        })->update([
            'status' => 2
        ]);
    }
}
