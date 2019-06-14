<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/13
 * Time: 16:49
 */
namespace App\Http\Controllers\home;

use App\Http\Models\currency\CapitalModel;
use App\Http\Models\home\demandModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;
use Yansongda\Pay\Pay;

class demandController extends BaseController
{
    public function index()
    {
        $items = demandModel::where('status', 303)->paginate(40);
        return view('home.demand', compact('items'));
    }
}
