<?php
use Illuminate\Support\Facades\Storage;

/**
 * Created by PhpStorm.
 * EstablishUser: chai
 * Date: 2019/3/27
 * Time: 10:30
 * FinalModifier : chai
 */
class FileUpload
{
    private static $image_type = ['gif', 'jpg', 'jpeg', 'png'];//图片上传格式，用于区分是否是可上传图片
    private static $file_type = ['txt', 'xls', 'docx', 'dox', 'ppt'];//文件上传格式，用于区分是否是可上传文件
    private static $pic_dir = 'images';          //默认图片上传目录
    private static $file_dir = 'files';          //默认文件上传目录
    private static $rand_char = 'qQwWeErRtTyYuUiIoOpPaAsSdDfFgGhHjJkKlLzZxXcCvVbBnNmM123456789';

    /**
     * 上传文件入口
     * @param $file
     * @return array
     */
    public static function folderInfo($file, $name = 'file')
    {
        if($name != 'file') {
            $file = $file->file($name);
        }
        if(empty($file)) {
            throw new Exception("请选择上传内容！");
        }
        return self::checkFileType($file);
    }

    /**
     * 判断上传文件的类别进行不同类型上传。
     * 并在上传过后生成文件名返回
     * @param $file
     * @return array
     * @throws Exception
     */
    protected static function checkFileType($file)
    {
        $result = [];
        if(is_array($file)) {
            foreach ($file as $item) {
                if(!$item->isValid()) {
                    throw new Exception("上传文件错误, 请联系管理员！");
                }
                $file_type = $item->getClientOriginalExtension();
                if(in_array($file_type, self::$image_type)) {
                    $result[] = self::getManyImageInfo($item);
                } else if(in_array($file_type, self::$file_type)) {
                    $result[] = self::getManyFileInfo($item);
                } else {
                    throw new Exception("上传文件类型: ".$file_type." 错误, 请联系管理员！");
                }
            }
        } else {
            $file_type = $file->getClientOriginalExtension();
            if(in_array($file_type, self::$image_type)) {
                $result[] = self::getManyImageInfo($file);
            } else if(in_array($file_type, self::$file_type)) {
                $result[] = self::getManyFileInfo($file);
            } else {
                throw new Exception("上传文件类型: ".$file_type." 错误, 请联系管理员！");
            }
        }
        return $result;
    }

    /**
     * 上传图片操作
     * 目前业务并不复杂，故此上传简单。
     * 后期可进行优化
     * @param $file
     * @return string
     */
    protected static function getManyImageInfo($file)
    {
        //生成文件名拼接后缀名
        $file_name = self::getUploadFileName(12). '.' .$file->getClientOriginalExtension();
        //获取文件路径地址
        $path = $file->getRealPath();
        //上传到指定地址
        Storage::disk('image')->put($file_name, file_get_contents($path));
        return $file_name;
    }

    /**
     * 上传文件操作
     * 目前业务并不复杂，故此上传简单。
     * 后期可进行优化
     * @param $file
     * @return string
     */
    protected static function getManyFileInfo($file)
    {
        //文件上传保持原名称
        $file_name = $file->getClientOriginalName();
        $path = $file->getRealPath();
        Storage::disk('file')->put($file_name, file_get_contents($path));
        return $file_name;
    }

    /**
     * 生成上传文件名
     * @param $length 文件名称长度
     * @param string $chars 文件名内容组合
     * @return string
     */
    protected static function getUploadFileName($length)
    {
        $chars = self::$rand_char;
        $hash = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $hash .= $chars[mt_rand(0, $max)];
        }
        return $hash;
    }

    /**
     * 文件展示
     * @param $type
     * @param $path
     * @return mixed
     */
    public static function url($type, $path)
    {
        return Storage::disk($type)->url($path);
    }

    /**
     * 删除文件
     * @param $type
     * @param $path
     * @return bool
     */
    public static function del($type, $path)
    {
        return Storage::disk($type)->delete($path);
    }
}

