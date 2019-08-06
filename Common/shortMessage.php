<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/17
 * Time: 10:35
 */
class shortMessage
{
    protected static $uid = 'EpsJsKZCyEQA'; //微米，短信uid
    protected static $uid_pass = 'rmy7t4x8'; //微米，短信uid密码
    protected static $cid = 'H2glXWtf4DP4'; //微米，短信cid 模板id
    protected static $tips = [
        'empty' => '非法操作, 手机号码为空',
        'wrongFormat' => '非法操作, 手机号码格式不正确',
    ];

    /**
     * 入口
     *
     * @param string $mobile
     * @param string $message
     * @return mixed
     * @throws Exception
     */
    public static function entrance(string $mobile, string $message, $uid)
    {
        if(!$mobile) {
            throw new Exception(self::$tips['empty']);
        }
        if(!is_mobile($mobile)) {
            throw new Exception(self::$tips['wrongFormat']);
        }
        if(empty($uid)) {
            $uid = self::$uid;
        }
        return self::send($mobile, $message, $uid);
    }

    /**
     * 短信调用
     *
     * @param string $mobile
     * @param string $message
     * @return mixed
     */
    public static function send(string $mobile, string $message, $uid)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://api.weimi.cc/2/sms/send.html");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            'uid='.$uid.'&pas='.self::$uid_pass.'&mob='.$mobile.'&cid='.self::$cid.'&p1='.$message.'&p2&type=json');
        $res = curl_exec( $ch );
        curl_close( $ch );
        return json_decode($res);
    }
}
