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
use Illuminate\Support\Facades\Redis;
use Log;

class keyword extends Command
{
    /**
     * The name and signature of the console command.The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'keyword';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '热搜处理';

    public function handle()
    {
        $search_keywods = json_decode(Redis::get('keyword'));
        Log::info('热搜', [
            'info' => $search_keywods
        ]);
        $keywods = [];
        if(!empty($search_keywods)) {
            foreach ($search_keywods as $keywod) {
                if(isset($keywod[$keywod])) {
                    $keywods[$keywod]['sort'] += 1;
                } else {
                    $keywods[$keywod] = [
                        'name' => $keywod,
                        'sort' => 0
                    ];
                }
            }
            $data = array_column(array_values($keywods), 'sort');
            array_multisort($data, SORT_DESC, $keywods);
            Log::info('热搜', [
                'info' => $keywods
            ]);
            Redis::set('keywords', json_encode($keywods));
        }
    }
}
