<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/15
 * Time: 14:29
 */
namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * ajax提交返回
     * @param array $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxReturn($data = ['info' => '操作成功', 'status' => 200, 'url' => '', 'data' => ''],
                               $status = 200)
    {
        $first = substr($status, 0, 1);
        switch ($first) {
            case 2:
                $message = $data;
                break;
            case 4:
                $message = [
                    'errors' => [
                        'info' => [$data['info']]
                    ]
                ];
                break;
            case 5:
                $message = [
                    'errors' => [
                        'info' => [$data['info']]
                    ]
                ];
                break;
            default:
                $message = $data;
                break;
        }
        return response()->json($message, $status);
    }
}
