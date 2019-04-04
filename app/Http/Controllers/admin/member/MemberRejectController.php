<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/3
 * Time: 16:50
 */
namespace App\Http\Controllers\admin\member;

use App\Http\Controllers\admin\BaseController;
use Illuminate\Support\Facades\Request;

class MemberRejectController extends BaseController
{
    public function makeQuery($query, $data)
    {
        return $query;
    }

    public function index(Request $request)
    {

    }
}
