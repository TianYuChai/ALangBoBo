<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/5/17
 * Time: 22:36
 */
namespace App\Http\Controllers\home\personal;

use App\Http\Controllers\home\BaseController;
use App\Http\Models\currency\MerchantModel;
use Illuminate\Support\Facades\Auth;

class PersonalMerchantController extends BaseController
{
    const ROUTE = HOME_PERSONAL;
    protected $model;

    public function __construct(MerchantModel $model)
    {
        $this->middleware(function ($request, $next) use ($model){
            $this->userId = Auth::guard('web')->user()->id;
            $this->model = $model;
            return $next($request);
        });
    }

    public function index()
    {
        return view(self::ROUTE . 'merchantEntry');
    }
}