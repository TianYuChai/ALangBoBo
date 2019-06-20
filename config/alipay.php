<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/14
 * Time: 15:58
 */
return [
    'pay' => [
        // APPID
        'app_id' => '2019042064134368',
        // 支付宝 支付成功后 主动通知商户服务器地址  注意 是post请求
        'notify_url' => '',
        // 支付宝 支付成功后 回调页面 get
        'return_url' => '',
        // 公钥（注意是支付宝的公钥，不是商家应用公钥）
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAkhS4Cpk/g1JvLtdoFlMcpvNY8d4cQCrdgjodUV0piSYpbAf80VOZYsd66tz0GJcRzhyAbVaHXJticR/pkX06anGKn+Mp4+X/vhGIe6b/RiFlbZBbU/91ov5NHReNqYKDZFuo73o818WOSj32bRD6mwO6rFM4Tx5mQYoIZJ0XqTy2kC6HeWvD5QwrDm8DqCJ6Q6gj5DbYiuMYHLRPZk2dBqb4GdIXtTNbRK33hopI8lau32+qP4RZgQQZ/5s7b7VN87RWZPYizg1t4B9YkQ+yaJmGdXRLmN2DPh/0fUDBPYO4Cgciqy4+PEbkuWwWgrpWAnuUaLKni/vdfXpeOtWoYwIDAQAB',
        // 加密方式： **RSA2** 私钥 商家应用私钥
        'private_key' => 'MIIEpQIBAAKCAQEApVQcw+rstL10VUM2bfXh1jh/wfRNA6i5Z9p5v72osOl3tIOU4NdtSBgKxmyiNFqH/4cF1ULxVMRx6eUDAunU+6Fa5+C2BCRj4CZnaDagrwa7+5z/OoOYmtaUBCt371vzvhmnLOma4LNESA4tRE3Cb+GD1jQaVko+DQvadCj+7gaQlCmS84pfaMEypiQ42/+1G0E2dEuCeOImlrmcJh+YZZjKFyNFqfWHUAZJBTVVltaoh5KCwuTqV8MzX+RK3nqmI6nIGIGq9kmyu1vz9QVUPiP98lyh2cgJYpVK3v5i0AzPrlAu4TCWlgK+aUawn7EHG68/+XivFWbnsfn8Dzc/DwIDAQABAoIBAQCbmojgVJGoos+FGBd4cv21U8Pa1oZNtVWbS2Nfda/5oiNKQLW00M1IF2i8zK31vGdXtstkpvbgo2vbifHFojMVCg63QyXMzDs8Uqjsys19LkdrT55ggk71HJR/QDJHlDHab+aKPOvKJK9VahJswQsJpiUhTDSllobEXK2kupkFiKDUxqXOeePmPAbyIhzaipyIQfvLq2YjsHm8oGq6CXm617+hIPKGXyLzuF7d7f58hZydskqc1+eIB6dKMWJzSfjTivQ0c8w4hDjFTjeeJAWNAwHVoTvcVDQtXoQjTciVGVPmrWJ5a7QPTmb7XCCmTmbZpJkASPhQFuOxl9MvUSEhAoGBANL+R95D82y3XCgmXsXXhRS+wP/84sjSXshRqAEjSqi4yR+YXaMCzWsDOo07GzG5zWvM2xbH3AtnguNdT9pEEPhsZD7pRmX2ha2Q7zbbsQn1wc4780wFsqWOdKqM/U/8RQSJRCMfVi77UX6UWE3jDj/ASqou24IHCK6U7Y6duB2nAoGBAMiYN1/QxL/XvFNch9q9VAHj5hHWUEn1+P2c0o55p5L/QVueb8Il/em0O5+siBrwJuyDzdLtwGE735iobH6YYr0fuC9y4bgtbPluOoQWsw9Rq2191pLjx6Ch8FwuXrBJZp9CXA0OneDsFiaVC3zZT2keonBV1zhKcW6CbR5RIZBZAoGAXjySLtScqYbv00Ln+2c6GjzkiLETPWywRrop1nBDzT3THph34fHDe7NSeHfYuonpFOfHRtJ3FmTiEdjAbJUQG1SWJX8dITdNF2tvXEodNXydVhZyoRa+ZrFMrEwSa6IZ1V/VnfZGEO/Qwz9QfWEXISQqdP4+rkGkAA2mWJda/2sCgYEAwf7cBtErhnFI08H4LSbPGOjjtzpx+aVlwTgqNdoXo0UzWzzVzojZkGxbAWhlVNAOhMxPgP+n/yFddBDmpGQRkeAcS98pxuo/qtbcxqQBVf5g8QozO2oIxSP4Bd5eetTx53HQ/lu1ejI4leWs73hmoT4cUNHjy6/LFdoTV6+U6zkCgYEAkqWl5wwdbtrGXfsW36eNeydn67yEGtGEtPyuDTGC9MwhbgY+FNNPdJobyLhSgZMhSxZMQeKzigmrSa4WzXa2/1es3wz+ZWSWSUANEC1/7dup/vgkKRa4oxrc+rjfbAk3y6y3W8oyZDl3/umCIMyv0/4FK21sUFLBjyb3LfTJ5Ls=',
        'log' => [ // optional
            'file' => '../storage/logs/alipay.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'daily', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        'mode' => 'normal', // optional,设置此参数，将进入沙箱模式
    ]
];
