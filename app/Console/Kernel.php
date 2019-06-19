<?php

namespace App\Console;

use App\Console\Commands\Banner;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\Test;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        Banner::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('banner')->everyMinute()->timezone('Asia/Shanghai')->runInBackground(); //轮播图
        $schedule->command('black')->everyMinute()->timezone('Asia/Shanghai')->runInBackground(); //黑名单
        $schedule->command('credit')->everyMinute()->timezone('Asia/Shanghai')->runInBackground(); //解冻保证金
        $schedule->command('order_timeout_down')->everyMinute()->timezone('Asia/Shanghai')->runInBackground(); //订单未支付超时处理
        $schedule->command('sign_timeout')->everyMinute()->timezone('Asia/Shanghai')->runInBackground(); //订单定时签收
        $schedule->command('order_complete_timeout')->everyMinute()->timezone('Asia/Shanghai')->runInBackground(); //订单定时完成
        $schedule->command('keyword')->everyMinute()->timezone('Asia/Shanghai')->runInBackground(); //热搜处理
        $schedule->command('demand_complete')->everyMinute()->timezone('Asia/Shanghai')->runInBackground(); //需求评价
        $schedule->command('demand')->everyMinute()->timezone('Asia/Shanghai')->runInBackground(); //未支付需求
        $schedule->command('demand_wait')->everyMinute()->timezone('Asia/Shanghai')->runInBackground(); //等待接单需求
        $schedule->command('ceshi')->everyMinute()->timezone('Asia/Shanghai')->runInBackground(); //等待接单需求
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
