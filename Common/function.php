<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/3/27
 * Time: 10:04
 */

/**
 * 正则判断字符是否含有中文
 * whole 全是中文, contain 含有中文, true 无中文
 * @param string $str
 * @return bool|string
 */
function regularHaveSinoram(string $str)
{
    if(!is_array($str)) {
        if (preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $str) > 0) {
            $res = false;
        } else if(preg_match('/[\x{4e00}-\x{9fa5}]/u', $str) > 0) {
            $res = false;
        } else {
            $res = true;
        }
        return $res;
    }
}

/**
 * 获取字符串长度
 *
 * @param string $str
 * @return bool|int
 */
function stringLen(string $str)
{
    return mb_strlen($str, 'UTF8');
}

/**
 * 无限分类
 *
 * @param $data
 * @param $pid
 * @param bool $type
 * @return array
 */
function infiniteCate($data, $pid = 0, $type = true)
{
    $result = [];
    foreach ($data as $key => $value) {
        if($value->p_id == $pid) {
            if($type) {
                $result[] = [
                    'id' => $value->id,
                    'name' => $value->cate_name,
                    'status_name' => $value->status_name,
                    'level' => $value->level,
                    'tip' => $value->status == 0 ? '禁用' : '启用',
                    'children' => infiniteCate($data,$value->id)
                ];
            } else {
                $result[] = [
                    'id' => $value->id,
                    'children' => infiniteCate($data, $value->id, false)
                ];
            }
            unset($data[$key]);
        }
    }
    return $result;
}

/**
 * 根据子类获取父类和祖父类
 *
 * @param $data
 * @param $pid
 * @param int $count
 * @return array
 */
function getTopComId($data, $pid = 0, $count = 0)
{
    static $result = [];
    foreach ($data as $key => $value) {
        if($value->id == $pid) {
            if($count != 0) {
                $result[] = [
                    'id' => $value->id,
                    'level' => $value->level,
                    'name' => $value->cate_name
                ];
            }
            getTopComId($data, $value->p_id, $count+1);
            unset($data[$key]);
        }
    }
    return $result;
}

/**
 * 数组排序
 *
 * @param $cates
 * @param string $key
 * @return mixed
 */
function array_sorts($cates, string $key, $arg = SORT_DESC)
{
    if(count($cates) <= 1) {
        return $cates;
    }
    $last_names = array_column($cates, $key);
    array_multisort($last_names, $arg, $cates);
    return $cates;
}

/**
 * 验证Url是否可用
 *
 * @param string $url
 * @return bool
 */
function verificationUrl(string $url)
{
    $success = get_headers($url,1);
    if(preg_match('/200/',$success[0])){
        return true;
    }else{
        return false;
    }
}

/**
 * 获取当前时间
 *
 * @param $type
 * @return false|string
 */
function getTime($type = '')
{
    switch ($type) {
        case 'ymd':
            $time = date('Y-m-d', time());
        break;
        case  'his':
            $time = date('H:i:s', time());
        break;
        default:
            $time = date('Y-m-d H:i:s', time());
    }
    return $time;
}

/**
 * 验证是否是手机号
 *
 * @param string $mobile
 * @return bool
 */
function is_mobile(string $mobile)
{
    $regular = "/^1[34578]\d{9}$/";
    if(preg_match($regular, $mobile)){
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

/**
 * 判断身份证
 *
 * @param $number
 * @return bool
 */
function is_idcard($number)
{
    $regular = "/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/";
    if(preg_match($regular, $number)){
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

/**
 * 图片转码base64
 * 图片：路径
 * @param $image_file
 * @return string 不带入data:image/jpg;base64,
 */
function imgtobase64($img)
{
    $base64_image  = base64_encode(file_get_contents($img));
    return $base64_image;

}

/**
 * 生成订单号
 *
 * @return string
 */
function create_order_no()
{
    $order_no = date('Ymd').substr(time(), -5) .
        substr(microtime(), 2, 5) . sprintf('%02d', rand(1000, 9999));
    return $order_no;
}

/**
 * 生成验证码
 *
 * @param int $num
 * @return string
 */
function code(int $num = 6)
{
    return str_pad(mt_rand(0, pow(10, $num) - 1), $num, '0', STR_PAD_LEFT);
}
