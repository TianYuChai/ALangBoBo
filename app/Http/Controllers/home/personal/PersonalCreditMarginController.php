<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/13
 * Time: 10:16
 */
namespace App\Http\Controllers\home\personal;

use App\Http\Controllers\home\BaseController;

class PersonalCreditMarginController extends BaseController
{
    const ROUTE = HOME_PERSONAL; //视图路径
    protected $model;

    public function index()
    {
        $items = [
            'alltrade' => [],
            'withdraw' => [],
            'recharge' => []
        ];
        return view(self::ROUTE . 'creditMargin', compact('items'));
    }
}
