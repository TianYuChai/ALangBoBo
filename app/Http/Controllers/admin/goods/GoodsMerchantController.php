<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/5/25
 * Time: 20:04
 */
namespace App\Http\Controllers\admin\goods;

use App\Http\Controllers\admin\BaseController;
use App\Http\Models\currency\MerchantModel;
use Input;
use Exception;

class GoodsMerchantController extends BaseController
{
    const ROUTE = ADMIN_GOODS_CATEGORY. 'merchant.'; //视图路径;

    public function makeQuery($query)
    {
        $name = trim(Input::get('account', ''));
        $shopName = trim(Input::get('shop_name', ''));
        return $query->SearchName($name)
                     ->SearchShopName($shopName);
    }

    public function index()
    {
        $query = $this->makeQuery(new MerchantModel());
        $items = $query->where('status', 1)->paginate(parent::$page_limit);
        $data = [
            'items' => $items,
            'merchant_count' => $items->count()
        ];
        return view(self::ROUTE. 'index', compact('data'));
    }

    /**
     * 展示数据
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws Exception
     */
    public function show($id)
    {
        $item = MerchantModel::where([
            'id' => intval($id),
            'status' => 1
        ])->first();
        if(!$item) {
            throw new Exception('数据错误，请刷新重试');
        }
        return view(self::ROUTE . 'details', compact('item'));
    }
}