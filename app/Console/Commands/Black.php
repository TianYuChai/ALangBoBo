<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/16
 * Time: 16:22
 */
namespace App\Console\Commands;

use App\Http\Models\currency\CapitalModel;
use App\Http\Models\currency\UserModel;
use App\Http\Models\home\blackTimeModel;
use Illuminate\Console\Command;

class Black extends Command
{
    /**
     * The name and signature of the console command.The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'black';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '去除黑名单';

    public function __construct()
    {
        parent::__construct();
        $this->model = blackTimeModel::class;
        $this->userModel = UserModel::class;
    }

    /**
     * 去除黑名单
     */
    public function handle()
    {
        $items = $this->model::where('time', '<', getTime())->get(['gid']);
        $this->userModel::whereIn('id', $items)->update(['status' => 1]);
    }
}
