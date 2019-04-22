<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/22
 * Time: 9:57
 */
class faceReacognition
{
    protected static $_AccKey = 'LTAIglaPUQNcgCZp'; //Access Key ID
    protected static $_AccSecret = 'CTfvMV3hZYy4UQ9nF4B2HyGHmZmjCS'; //Access Key Secret
    protected static $tips = []; //提示信息

    /**
     * 入口
     *
     * @param $img_1
     * @param $img_2
     * @param int $type
     * @type 0 请求指为url 1 请求为base64 不带入data:image
     */
    public static function entrance($img_1, $img_2, $type = 1)
    {
       return self::send($img_1, $img_2, $type);
    }

    /**
     * 发送阿里云请求
     *
     * @param $img_1
     * @param $img_2
     * @param $type
     * @return mixed
     */
    public static function send($img_1, $img_2, $type)
    {
        $data = [
            'type' => intval($type),
        ];
        if($data['type'] == 0) {
            $data['image_url_1'] = $img_1;
            $data['image_url_2'] = $img_2;
        } else {
            $data['content_1'] = $img_1;
            $data['content_2'] = $img_2;
        }
        dd($data);
        $url = "https://dtplus-cn-shanghai.data.aliyuncs.com/face/verify";
        $options = array(
            'http' => array(
                'header' => array(
                    'accept'=> "application/json",
                    'content-type'=> "application/json",
                    'date'=> gmdate("D, d M Y H:i:s \G\M\T"),
                    'authorization' => ''
                ),
                'method' => "POST", //可以是 GET, POST, DELETE, PUT
                'content' =>  json_encode($data)//如有数据，请用json_encode()进行编码
            )
        );
        $http = $options['http'];
        $header = $http['header'];
        $urlObj = parse_url($url);
        if(empty($urlObj["query"]))
            $path = $urlObj["path"];
        else
            $path = $urlObj["path"]."?".$urlObj["query"];
        $body = $http['content'];
        if(empty($body))
            $bodymd5 = $body;
        else
            $bodymd5 = base64_encode(md5($body,true));
        $stringToSign = $http['method']."\n".$header['accept']."\n".$bodymd5."\n".$header['content-type']."\n".$header['date']."\n".$path;
        $signature = base64_encode(
            hash_hmac(
                "sha1",
                $stringToSign,
                self::$_AccSecret, true));
        $authHeader = "Dataplus ".self::$_AccKey.":"."$signature";
        $options['http']['header']['authorization'] = $authHeader;
        $options['http']['header'] = implode(
            array_map(
                function($key, $val){
                    return $key.":".$val."\r\n";
                },
                array_keys($options['http']['header']),
                $options['http']['header']));
        $context = stream_context_create($options);
        $file = file_get_contents($url, false, $context );
        return json_decode($file);
    }
}
