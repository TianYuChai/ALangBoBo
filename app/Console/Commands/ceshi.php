<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;

class Banner extends Command
{
    /**
     * The name and signature of the console command.The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '测试';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '用于测试crontab是否可用';

    public function handle()
    {
        Log::info('测试任务调度', [
            'time' => getTime(),
            'info' => 1
        ]);
    }
}
