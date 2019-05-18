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
use App\Http\Requests\home\persanal\PersonalMerchantRequest;
use App\Http\Services\home\LoginService;
use App\Http\Services\home\persanal\PersonalMechantService;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\DB;

class PersonalMerchantController extends BaseController
{
    const ROUTE = HOME_PERSONAL;
    protected $model;
    protected $mobile;
    protected $user;
    public function __construct(MerchantModel $model)
    {
        $this->middleware(function ($request, $next) use ($model){
            $this->user = Auth::guard('web')->user();
            $this->userId = Auth::guard('web')->user()->id;
            $this->mobile = Auth::guard('web')->user()->number;
            $this->model = $model;
            return $next($request);
        });
    }

    /**
     * 展示商家页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $item = $this->model::where('uid', $this->userId)->first();
        $wther = isset($item) ? ($item->status == 0 && $this->user->registerauditing == null ? true : false) : false;
        $register = isset($item) ? '驳回原因: ' . $this->user->registerauditing['reject'] . ', 请修改后, 重新进行申请！' : "";
        $category = isset($item) ? intval($item->category) : 1;
        return view(self::ROUTE . 'merchantEntry', compact('item', 'wther', 'register', 'category', 's'));
    }

    /**
     * 商家入驻操作
     *
     * @param PersonalMerchantRequest $request
     * @param PersonalMechantService $service
     * @param LoginService $loginService
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PersonalMerchantRequest $request, PersonalMechantService $service, LoginService $loginService)
    {
       try {
            $code = trim($request->verifyCode);
            $loginService->vefiShort($this->mobile, $code);
            $data = $service->start($request);
            $service->create($data);
            return $this->ajaxReturn();
       } catch (Exception $e) {
           return $this->ajaxReturn([
               'info' => $e->getMessage(),
               'status' => 510
           ], 510);
       }
    }
}