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
use App\Http\Models\home\personal\CancellModel;
use App\Http\Requests\home\persanal\PersanalAddressRequest;
use App\Http\Services\home\AlipayService;
use App\Http\Services\home\LoginService;
use App\Http\Services\home\PersanalService;
use App\Http\Services\home\persanal\PersanalAddressService;
use Illuminate\Http\Request;
use Exception;
use FileUpload;
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
            $query->where('uid', $this->userId)->whereIn('category', [100, 300, 600]);
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
            if(date('Y', time()) != $home_live['YYYY'] &&
                date('M', time()) != $home_live['MM'] &&
                date('D', time()) != $home_live['DD']) {
                $time = $home_live['YYYY'] . '/' . $home_live['MM'] . '/' . $home_live['DD'];
            }
            UserModel::where('id', $request->user()->id)->update([
                'live' => $live,
                'home' => $home,
                'sex' => $home_live['sex'],
                'datebirth' => $time ?? ""
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

    /**
     * 删除地址信息
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * 添加地址信息
     *
     * @param PersanalAddressRequest $addressRequest
     * @param PersanalAddressService $addressService
     * @return \Illuminate\Http\JsonResponse
     */
    public function createAddress(PersanalAddressRequest $addressRequest, PersanalAddressService $addressService)
    {
        try {
            $data = $addressService->addressFilter($addressRequest);
            $addressService->create($data);
            return $this->ajaxReturn([
                'status' => 200,
                'info' => '添加成功'
            ], 200);
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => 510
            ], 510);
        }
    }

    /**
     * 更新处理地址状态
     *
     * @param $id
     * @param Request $request
     * @param PersanalAddressService $addressService
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleAddress($id, Request $request, PersanalAddressService $addressService)
    {
        try {
            $type = $request->type == "delivery_goods" ? 700 : 701;
            $addressService->handleStatus($type);
            $item = $this->addressModel::where([
                'id' => $id,
                'uid' => $this->userId,
                'category' => 900,
            ])->first();
            if($item->status == 699) {
                $item->status = $type;
            } else {
                $item->status = $item->status == $type ? $item->status : 703;
            }
            $item->save();
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => 510
            ], 510);
        }
    }

    /**
     * 注销账户
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cancellationUser()
    {
        return view(self::ROUTE. 'cancellationUser');
    }

    /**
     * 账户注销处理
     *
     * @param Request $request
     * @param PersanalService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancellHandleUser(Request $request, PersanalService $service)
    {
        try {
            $service->vefiShort($request->verifyCode);
            CancellModel::updateOrCreate([
                'uid' => $request->user()->id
            ],[
                'uid' => $request->user()->id
            ]);
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => 510
            ], 510);
        }
    }

    public function cashWithdrawal(Request $request, AlipayService $alipayService, LoginService $loginService)
    {
        try {
            $method = trim($request->input('method', ''));
            $money = trim($request->money);
            $code = trim($request->code);
            $account = trim($request->account);
            if(!$money) {
                throw new Exception('请填入提现金额', 510);
            }
            if(!regularHaveSinoram($money)) {
                throw new Exception('提现金额包含中文', 510);
            }
            if(!preg_match('/^[0-9]+(.[0-9]{1,2})?$/', $money)) {
                throw new Exception('提现金额类型错误', 510);
            }
            if($money < 100) {
                throw new Exception('提现金额需大于100元', 510);
            }
            if($money > Auth::guard('web')->user()->available_money) {
                throw new Exception('超出可提现范围', 510);
            }
//            $loginService->vefiShort(Auth::guard('web')->user()->number, $code);
            if($method == 'Alipay') {
                $money = 0.2;
                $result = $alipayService->cashWith($money, $account);
            } else if($method == 'WeChat') {

            } else {
                throw new Exception('提现类型错误');
            }
            dd($result);
        } catch (Exception $e) {
            dd($e->raw);
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => $e->getCode()
            ], 510);
        }
    }
}
