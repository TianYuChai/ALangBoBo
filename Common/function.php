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

function stringLen(string $str)
{
    return mb_strlen($str, 'UTF8');
}
