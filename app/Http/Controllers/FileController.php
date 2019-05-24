<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/11
 * Time: 17:09
 */
namespace App\Http\Controllers;

use App\Http\Controllers\admin\BaseController;
use App\Http\Models\goods\goodsImgModel;
use Illuminate\Http\Request;
use FileUpload;
use Exception;
use Illuminate\Support\Facades\Auth;

class FileController extends BaseController

{
    private static $image_type = ['gif', 'jpg', 'jpeg', 'png'];//图片上传格式，用于区分是否是可上传图片
    private static $file_type = ['txt', 'xls', 'docx', 'dox', 'ppt'];//文件上传格式，用于区分是否是可上传文件

    public function fileupload(Request $request)
    {
        try {
            $type = $request->type;
            $image_path = $request->image_path;
            if(is_array($image_path)) {
                foreach ($image_path as $item) {
                    $this->delFile($item);
                }
            }
            if(!empty($type) && $type == 'goods') {
                if(!Auth::guard('web')->user()->merchant_due) {
                    throw new Exception('无法操作, 入驻费未缴纳或已到期');
                }
                $this->delGoods($image_path);
            }
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
     * 删除图片
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function del(Request $request)
    {
        try {
            $img_path = trim($request->img_path);
            $type = trim($request->input('type', ''));
            if(FileUpload::exists('image', $img_path)) {
                $this->delFile($request->img_path);
            }
            if(!empty($type)) {
                if(!Auth::guard('web')->user()->merchant_due) {
                    throw new Exception('无法操作, 入驻费未缴纳或已到期');
                }
                $this->delGoods($img_path);
            }
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => 510
            ], 510);
        }
    }

    /**
     * 删除对应的商品图片数据
     *
     * @param $img
     */
    protected function delGoods($img)
    {
        if(!is_array($img)) {
            goodsImgModel::where('img', $img)->delete();
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
