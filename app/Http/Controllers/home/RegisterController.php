<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/15
 * Time: 18:14
 */
namespace App\Http\Controllers\home;

class RegisterController extends BaseController
{
    public function index()
    {
        return view('home.register');
    }
}
