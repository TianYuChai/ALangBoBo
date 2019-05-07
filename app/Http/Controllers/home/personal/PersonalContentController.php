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
use App\Http\Models\home\personal\AddressModel;
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
    protected $model;
    protected $addressModel;
    /**
     * php 魔术方法获取用户id
     *
     * PersonalContentController constructor.
     */
    public function __construct(CapitalModel $model, AddressModel $addressModel)
    {
        $this->middleware(function ($request, $next) use ($model, $addressModel){
            $this->userId = Auth::guard('web')->user()->id;
            $this->model = $model;
            $this->addressModel = $addressModel;
            return $next($request);
        });
    }

    /**
     * 交易记录
     * alltrade 所有记录
     * withdraw 提现记录
     * recharge 充值记录
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //所有记录
        $items['alltrade'] = $this->model::where(function ($query) {
            $query->where('uid', $this->userId)->where('status', '!=', 1003);
        })->orderBy('updated_at', 'desc')->get();
        //提现记录
        $items['withdraw'] = $this->model::where(function ($query) {
           $query->where('uid', $this->userId)->where('category', 200);
        })->orderBy('updated_at', 'desc')->get();
        //充值记录
        $items['recharge'] = $this->model::where(function ($query) {
            $query->where('uid', $this->userId)->whereIn('category', [100, 600]);
        })->orderBy('updated_at', 'desc')->get();
        return view(self::ROUTE . 'index', compact('items'));
    }

    /**
     * 个人中心
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
                'home' => $home,
                'sex' => $home_live['sex']
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
     * 地址信息展示
     * 从service类中获取地址信息所需数据
     *
     * @param PersanalService $service
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function address(PersanalService $service)
    {
        $items = $service->address();
        return view(self::ROUTE. 'address', compact('items'));
    }

    public function addressDel($id)
    {
        try {
            $this->addressModel::destroy($id);
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => 510
            ], 510);
        }
    }
}
