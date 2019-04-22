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
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://dtplus-cn-shanghai.data.aliyuncs.com/face/verify");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec( $ch );
        curl_close( $ch );
        return json_decode($res);
    }
}
