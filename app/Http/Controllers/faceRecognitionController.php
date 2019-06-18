<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/19
 * Time: 10:24
 */
namespace App\Http\Controllers;

use App\Http\Controllers\home\BaseController;
use Illuminate\Http\Request;
use FileUpload;
use faceReacognition;
use Exception;
use Log;

class faceRecognitionController extends BaseController
{
    public function index(Request $request)
    {
        try {
            $face_img_data = FileUpload::getManyImageInfo($request->face_img, 'png');
            $face_img = FileUpload::url('image', $face_img_data);
            $crid_img = FileUpload::url('image', $request->crid_img);
            $res = faceReacognition::entrance($crid_img, $face_img, 0);
            Log:info('面部识别', json_encode($res));
            FileUpload::del('image', $face_img_data);
            if(isset($res->confidence)) {
                if(intval($res->confidence) >= 60) {
                    $contrast_value = true;
                } else {
                    $contrast_value = false;
                }
            } else {
                $recta = array_count_values($res->rectA);
                if(count($res->rectA) == $recta[0]) {
                    throw new Exception('未能识别身份证上人脸, 请重新上传');
                }
                $rectb = array_count_values($res->rectB);
                if(count($res->rectB) == $rectb[0]) {
                    throw new Exception('未能识别人脸, 请重新识别');
                }
            }
            return $this->ajaxReturn([
                'info' => $contrast_value,
                'status' => 200
            ], 200);
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => 510
            ], 510);
        }
    }
}
