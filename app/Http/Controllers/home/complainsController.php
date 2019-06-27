<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/27
 * Time: 15:25
 */
namespace App\Http\Controllers\home;

use App\Http\Controllers\home\BaseController;
use App\Http\Models\setup\complainModel;

class complainsController extends BaseController
{
    public function index()
    {
        $items = complainModel::where('status', 0)->paginate(parent::$page_limits);

        return view('home.complain', compact('items'));
    }
}
