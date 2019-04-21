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

class faceRecognitionController extends BaseController
{
    public function index(Request $request)
    {
        $face_img = $request->face_img;
        $crid_img = base64EncodeImage($request->crid_img);
        dd($crid_img);
    }
}
