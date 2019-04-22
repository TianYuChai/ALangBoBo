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

class faceRecognitionController extends BaseController
{
    public function index(Request $request)
    {
        try {
            $face_img = $request->face_img;
            $crid_img = imgtobase64(FileUpload::url('image', $request->crid_img));
            $res = faceReacognition::entrance($crid_img, $face_img, 1);
            if(isset($res->confidence)) {
                $data['contrast_value'] = intval($res->confidence);
            } else {
                foreach ($res->rectA as $recta) {

                }
            }
            return $this->ajaxReturn([
                'info' => '',
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
