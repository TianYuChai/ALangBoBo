<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $page_limit = 15;

    /**
     * ajax提交返回
     * @param array $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxReturn($data = ['info' => '操作成功', 'status' => 200, 'url' => ''], $status = 200)
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
            default:
                $message = $data;
            break;
        }
        return response()->json($message, $status);
    }
}
