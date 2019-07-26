<?php

namespace App\Jobs;

use App\Http\Models\currency\UserModel;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;


class orderSmSNotice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 120;

    public $tries = 3;
    protected $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id)
    {
       $user = UserModel::where('id', intval($user_id))->first();
       $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://api.weimi.cc/2/sms/send.html");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            'uid=EpsJsKZCyEQA&pas=rmy7t4x8&mob='.$this->user->number.'&cid=boF2H6bbmiYK&p1=&p2&type=json');
        $res = curl_exec( $ch );
        curl_close( $ch );
        Log::info('队列通知', [
            'info' => json_decode($res),
            'info_code' => json_decode($res)->code
        ]);
        if(json_decode($res)->code == 0) {
            $overdue_time = (strtotime(date('Y-m-d 24:00:00')) - time()) / 60;
            Cache::put('order:sms:notice:'. $this->user->id, $this->user->number, $overdue_time);
        }
    }
}
