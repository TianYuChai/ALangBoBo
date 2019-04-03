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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $file = \FileUpload::folderInfo($request, 'source');
        dd($file);
//        return view('admin.index');
    }

    public function welcome()
    {
        return view('admin.welcome');
    }
}
