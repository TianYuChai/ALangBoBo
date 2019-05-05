<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/25
 * Time: 10:38
 */
namespace App\Http\Controllers\home\personal;

use App\Http\Controllers\home\BaseController;
use App\Http\Models\currency\CapitalModel;
use App\Http\Models\currency\UserModel;
use App\Http\Services\home\PersanalService;
use Illuminate\Http\Request;
use Exception;
use FileUpload;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class PersonalContentController extends BaseController
{
    const ROUTE = HOME_PERSONAL; //视图路径
    protected $userId = null;

    /**
     * php 魔术方法获取用户id
     *
     * PersonalContentController constructor.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::guard('web')->user()->id;
            return $next($request);
        });
    }

    public function index()
    {
        $items = CapitalModel::where(function ($query) {
            $query->where('uid', $this->userId)->where('status', '!=', 1003);
        })->orderBy('updated_at', 'desc')->get();

        return view(self::ROUTE . 'index', compact('items'));
    }

    public function merchantData()
    {
        return view(self::ROUTE. 'merchant_data');
    }

    /**
     * 修改用户头像
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pictureUpload(Request $request)
    {
        try {
            UserModel::where('id', $request->user()->id)->update([
                'headimg' => $request->head_img
            ]);
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => 510
            ], 510);
        }
    }

    /**
     * 用户信息
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function homeLive(Request $request)
    {
        try {
            $home_live = $request->home_live;
            $live = $home_live['live_eprovince'] . '/' . $home_live['live_city'] . '/' . $home_live['live_district'];
            $home = $home_live['home_eprovince'] . '/' . $home_live['home_city'] . '/' . $home_live['home_district'];
            UserModel::where('id', $request->user()->id)->update([
                'live' => $live,
                'home' => $home
            ]);
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => 510
            ], 510);
        }
    }
}
