<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/29
 * Time: 17:22
 */
namespace App\Http\Controllers\home;

use App\Http\Models\goods\GoodsModel;
use Illuminate\Http\Request;
use Exception;

class shoppingController extends BaseController
{
    public function __construct(GoodsModel $goodsModel)
    {
        $this->user = Auth::guard('web')->user();
        $this->goods = $goodsModel;
    }

    public function buyNow($id, Request $request)
    {
        try {
            $item = $this->goods::where([
                'status' => 0,
                'id' => intval($id)
            ])->first();
            if(!$item) {
                throw new Exception('商品信息错误, 请刷新重试');
            }
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }
}
