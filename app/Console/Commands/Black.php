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
use App\Http\Models\home\theBlackListModel;
use Illuminate\Console\Command;
use Exception;
use Log;

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
        $this->theBlackListModel = theBlackListModel::class;
    }

    /**
     * 去除黑名单
     */
    public function handle()
    {
        try {
            $items = $this->model::where('time', '<', getTime())->get();
            $ids = $items->pluck('gid')->toArray();
            $this->theBlackListModel::whereIn('gid', $ids)->update(['status' => 2]);
            $this->userModel::whereIn('id', $ids)->update(['status' => 1]);
            $items->delete();
        } catch (Exception $e) {
            Log::info('脚本去除黑名单', [
                'time' => getTime(),
                'info' => $e->getMessage()
            ]);
        }
    }
}
