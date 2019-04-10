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
