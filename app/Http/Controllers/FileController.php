<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/11
 * Time: 17:09
 */
namespace App\Http\Controllers;

use App\Http\Controllers\admin\BaseController;
use Illuminate\Http\Request;
use FileUpload;
use Exception;

class FileController extends BaseController

{
    private static $image_type = ['gif', 'jpg', 'jpeg', 'png'];//图片上传格式，用于区分是否是可上传图片
    private static $file_type = ['txt', 'xls', 'docx', 'dox', 'ppt'];//文件上传格式，用于区分是否是可上传文件

    public function fileupload(Request $request)
    {
        try {
            $type = $request->type;
            $image_path = $request->image_path;
            $this->delFile($image_path);
            $file = $this->uploadFile($type, $request);
            if(is_array($file)) {
                return $this->ajaxReturn([
                    'status' => 200,
                    'url' => $file
                ], 200);
            }
        } catch (Exception $e) {
            $status = $type == 'layui' ? 200 : 510;
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => $status
            ], $status);
        }
    }

    /**
     * 清除上传文件之前文件数据
     *
     * @param $data
     * @throws Exception
     */
    public function delFile($data)
    {
        if(!empty($data)) {
            $path = explode('.', $data)[1];
            if(in_array($path, self::$image_type)) {
                FileUpload::del('image', $data);
            } else if(in_array($path, self::$file_type)) {
                FileUpload::del('file', $data);
            } else {
                throw new Exception("上传文件类型:错误, 请联系管理员！");
            }
        }
    }

    /**
     * 文件上传
     *
     * @param $type
     * @param $data
     * @return mixed
     */
    public function uploadFile($type, $data)
    {
        return $type == 'layui' ? FileUpload::folderInfo($data->file) : FileUpload::folderInfo($data, $data->name);
    }
}
