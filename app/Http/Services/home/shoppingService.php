<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/5/29
 * Time: 20:45
 */
namespace App\Http\Services\home;
use App\Http\Models\admin\goods\goodsCategoryAttributeModel;
use App\Http\Models\goods\goodsAttributeModel;
use App\Http\Models\goods\GoodsModel;
use Illuminate\Support\Facades\Auth;
use Exception;

class shoppingService extends BaseService
{
    public function __construct(GoodsModel $goodsModel,
                                goodsAttributeModel $goodsAttribute)
    {
         $this->user = Auth::guard('web')->user();
         $this->goods = $goodsModel;
         $this->goods_attribute = $goodsAttribute;
    }

    public function buyNow($id, $data)
    {
        $num = intval(trim($data['num']));
        $item = $this->goods::where([
            'status' => 0,
            'id' => intval($id)
        ])->first();
        if(!$item) {
            throw new Exception('商品信息错误, 请刷新重试');
        }
        if($item->presell_time && $item->presell_time < getTime()) {
            throw new Exception('商品为预售商品, 并未到达售卖时间');
        }
        if($num > $item->stocks) {
            throw new Exception('超出商品可售库存');
        }
        $this->buyNowAttribute($id, $data['attribute']);
        $money = bcmul($item->total_price, $data['num']);
        $this->authBuyWay($data['pay_method']);
    }

    /**
     * 确认商品属性
     *
     * @param $data
     * @throws Exception
     */
    protected function buyNowAttribute($id, $data)
    {
        $item = $this->goods_attribute::where('gid', intval($id))->whereIn('id', $data)->exists();
        if(!$item) {
            throw new Exception('存在不合法商品属性，请重新购买');
        }
    }

    protected function authBuyWay($data)
    {
        switch ($data) {
            case 'subscribed':
                if($this->user->frozen_capital < 0) {
                    throw new Exception('该购买方式下, 请先充值保证金');
                }
//                if()
            break;
            case 'paidin':

            break;
        }
    }
}