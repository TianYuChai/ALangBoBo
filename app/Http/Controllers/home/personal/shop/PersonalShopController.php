<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/9
 * Time: 16:39
 */
namespace App\Http\Controllers\home\personal\shop;

use App\Http\Controllers\home\BaseController;
use App\Http\Models\currency\MerchantModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use FileUpload;

class PersonalShopController extends BaseController
{
    const ROUTE = HOME_PERSONAL_SHOP; //视图路径
    protected $merchatModel; //个人商户信息

    public function __construct(MerchantModel $merchantModel)
    {
        return $this->merchatModel = $merchantModel;
    }

    public function index()
    {
        return view(self::ROUTE . 'index');
    }

    /**
     * 更新店铺图标
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTrademark(Request $request)
    {
       try {
            $tradimg = trim($request->trade_img);
            $item = $this->merchatModel::where('uid', $request->user()->id)->first();
            if(!empty($item->trademark)) {
                FileUpload::del('image', $item->trademark);
            }
            $item->trademark = $tradimg;
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
     * 更新商户信息
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        try {
            $name = trim($request->name);
            $address = trim($request->address);
            if(!$name) {
                throw new Exception('商品名称不可为空');
            }
            $item = $this->merchatModel::where('uid', $request->user()->id)->first();
            $item->shop_name = $name;
            $item->arrdess = $address;
            $item->save();
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => 510
            ], 510);
        }
    }
}
