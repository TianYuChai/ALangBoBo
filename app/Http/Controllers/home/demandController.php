<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/13
 * Time: 16:49
 */
namespace App\Http\Controllers\home;

class demandController extends BaseController
{
    public function index()
    {
        return view('home.demand');
    }
}
