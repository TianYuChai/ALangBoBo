<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/29
 * Time: 17:22
 */
namespace App\Http\Controllers\home;

use App\Http\Models\goods\GoodsModel;
use App\Http\Services\home\shoppingService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class shoppingController extends BaseController
{
    public function __construct(GoodsModel $goodsModel)
    {
        $this->user = Auth::guard('web')->user();
        $this->goods = $goodsModel;
    }

    public function buyNow($id, Request $request, shoppingService $service)
    {
        try {
            $service->buyNow($id, $request);
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }
}
