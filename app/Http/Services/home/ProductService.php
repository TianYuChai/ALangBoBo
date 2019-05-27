<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/27
 * Time: 14:17
 */
namespace App\Http\Services\home;

use App\Http\Models\admin\goods\goodsCategoryModel;
use App\Http\Models\goods\GoodsModel;

class ProductService extends BaseService
{
    public function __construct(goodsCategoryModel $goodsCategoryModel,
                                GoodsModel $goodsModel)
    {
        $this->goodsCategoryModel = $goodsCategoryModel;
        $this->goodsModel = $goodsModel;
    }

    public function entrance($type, $category_id = '')
    {
        switch ($type) {
            case $type:
                $data = $this->presellData([
                    'category_id' => $category_id
                ]);
            break;
            default:
            break;
        }
        dd();
    }

    /**
     * 预售商品
     *
     * 查询预售的商品，并将预售商品的分类查询出来作为导航栏的分类指向
     *
     * @param $where
     * @return array
     */
    protected function presellData($where)
    {
        $query = $this->goodsModel::where('presell_time', '<>', '')->where('status', 0);
        if($where['category_id']) {
           $query = $query->where('three_category', intval($where['category_id']));
        }
        $goods_data = $query->orderBy('id', 'desc')->paginate(1);
        $categorys = $this->goodsCategoryModel::where(function ($query) use ($goods_data) {
                            $query->whereIn('id', $goods_data->pluck('three_category'));
                            $query->where('status', 0);
                    })->orderBy('sort', 'desc')->get();
        return [
            'categorys' => $categorys,
            'goods' => $goods_data
        ];
    }
}
