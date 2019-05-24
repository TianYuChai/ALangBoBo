<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/17
 * Time: 11:01
 */
namespace App\Http\Controllers;

use App\Http\Controllers\home\BaseController;
use Illuminate\Http\Request;
use shortMessage;
use Exception;
use Illuminate\Support\Facades\Redis;

class shortMessageController extends BaseController
{
    /**
     * 短信验证码
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        try {
            $mobile = trim($request->mobile);
            $code = code();
            Redis::setex($mobile, 3 * 60, $code);
            $result = shortMessage::entrance($mobile, $code);
            if($result->code == 0) {
                return $this->ajaxReturn([
                    'info' => '发送成功',
                    'status' => 200,
                ], 200);
            }
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => 100
            ], 510);
        }
    }
}
