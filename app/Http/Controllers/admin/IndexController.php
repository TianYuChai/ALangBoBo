<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/3/28
 * Time: 11:14
 */
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Models\admin\BackstageModel;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
}
