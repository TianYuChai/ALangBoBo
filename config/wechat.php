<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/19
 * Time: 14:05
 */
return [
    'pay' => [
//        'appid' => 'wxb3fxxxxxxxxxxx', // APP APPID
        'app_id' => 'ww524a9783d531ec19', // 公众号 APPID
//        'miniapp_id' => 'wxb3fxxxxxxxxxxx', // 小程序 APPID
        'mch_id' => '1540573951',
        'key' => 'lDNgQmbm9WetFyQdSU4ua0vnr3gl9OQa',
        'notify_url' => '',
        'cert_client' => '../public/cert/apiclient_cert.pem', // optional，退款等情况时用到
        'cert_key' => '../public/cert/apiclient_key.pem',// optional，退款等情况时用到
        'log' => [ // optional
            'file' => '../storage/logs/wechat.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'daily', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        'mode' => 'normal', // optional, dev/hk;当为 `hk` 时，为香港 gateway。
    ]
];
