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
            $res = 'whole';
        } else if(preg_match('/[\x{4e00}-\x{9fa5}]/u', $str) > 0) {
            $res = 'contain';
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
function getTime($type)
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
    // 转化为大写，如出现x
    $number = strtoupper($number);
    //加权因子
    $wi = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
    //校验码串
    $ai = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
    //按顺序循环处理前17位
    $sigma = 0;
    for ($i = 0;$i < 17;$i++) {
        //提取前17位的其中一位，并将变量类型转为实数
        $b = (int) $number{$i};
        //提取相应的加权因子
        $w = $wi[$i];
        //把从身份证号码中提取的一位数字和加权因子相乘，并累加
        $sigma += $b * $w;
    }
    //计算序号
    $snumber = $sigma % 11;

    //按照序号从校验码串中提取相应的字符。
    $check_number = $ai[$snumber];

    if ($number{17} == $check_number) {
        return true;
    } else {
        return false;
    }
}
