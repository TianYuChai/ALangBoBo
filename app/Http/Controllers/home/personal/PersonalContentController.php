<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/25
 * Time: 10:38
 */
namespace App\Http\Controllers\home\personal;

use App\Http\Controllers\home\BaseController;

class PersonalContentController extends BaseController
{
    const ROUTE = HOME_PERSONAL; //视图路径

    public function index()
    {

        return view(self::ROUTE . 'index');
    }
}
