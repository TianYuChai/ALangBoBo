<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/14
 * Time: 14:08
 */
namespace App\Http\Controllers\home;
use Illuminate\Http\Request;
use Pay;
use Exception;
use URL;

class PayController extends BaseController
{
    protected $state = [
        100 => '保证金',
        200 => '入驻费',
    ];
    public function entrade($state, Request $request)
    {
        try {
            $status = trim($request->status);
            $data = $request->all();
            switch ($status) {
                case 100;
                    $this->bond($data);
                break;
                case 200;
                    $this->settle($data);
                break;

            }
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }

    protected function bond($data)
    {

    }

    protected function settle($data)
    {

    }
}
