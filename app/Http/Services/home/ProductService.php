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
use Illuminate\Support\Facades\Redis;

class ProductService extends BaseService
{
    public function __construct(goodsCategoryModel $goodsCategoryModel,
                                GoodsModel $goodsModel)
    {
        $this->goodsCategoryModel = $goodsCategoryModel;
        $this->goodsModel = $goodsModel;
    }

    public function entrance($type, $wherePrice = [], $whereSearch = [])
    {
        $type = explode('-', $type);
        switch ($type[0]) {
            case 'presell':
                $data = $this->presellData([
                    'category_id' => $type[1],
                    'price' => $wherePrice
                ]);
            break;
            case 'search':
                $data = $this->searchData([
                    'price' => $wherePrice,
                    'keyword' => $whereSearch
                ]);
            break;
            default:
                $data = $this->optherData([
                    'category_id' => $type[1],
                    'price' => $wherePrice
                ]);
            break;
        }
        return $data;
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
        $query = $this->goodsModel::where('status', 0)->where('presell_time', '<>', '');
        if($where['category_id'] != 'all') {
           $query = $query->where('three_category', intval($where['category_id']));
        }
        $goods_data = $query->SearchPrice($where['price'])->orderBy('id', 'desc')->paginate(self::$page_limit);
        $categorys = $this->goodsCategoryModel::where('status', 0)
                            ->where(function ($query) use ($goods_data) {
                            $query->whereIn('id', $goods_data->pluck('three_category')->toArray());
                    })->orderBy('sort', 'desc')->get();
        return [
            'categorys' => $categorys,
            'goods' => $goods_data,
            'nav' => '预售产品',
            'selected' => !empty($where['category_id']) ? intval($where['category_id']) : ''
        ];
    }

    /**
     * 其他类别产品
     *
     * 查询其他类别产品, 并将其所属二级分类查询出来
     *
     * @param $where
     * @return array
     */
    protected function optherData($where)
    {
        $nav = $this->goodsCategoryModel::where('status', 0)
                            ->where('id',  intval($where['category_id']))->first();
        switch ($nav->level) {
            case 1:
                $where_key = 'main_category';
                break;
            default:
                $where_key = 'three_category';
                break;
        }
        $goods_data = $this->goodsModel::where('status', 0)
                                        ->where($where_key, intval($where['category_id']))
                                        ->where('presell_time', null)
                                        ->SearchPrice($where['price'])
                                        ->orderBy('id', 'desc')->paginate(self::$page_limit);

        $categorys = $this->goodsCategoryModel::where('status', 0)->when($where_key == 'three_category',
            function ($query) use($nav) {
            $query->where('p_id', $nav->p_id);
        }, function ($query) use($nav){
            $query->where('p_id', intval($nav->id));
        })->orderBy('sort', 'desc')->get();
        if($where_key == 'main_category') {
            $categorys = $this->goodsCategoryModel::where('status', 0)
                        ->whereIn('p_id', $categorys->pluck('id')->toArray())->get();
        }
        return [
            'categorys' => $categorys,
            'goods' => $goods_data,
            'nav' => $nav->parent_message,
            'selected' => $nav->id
        ];
    }

    /**
     * 搜索
     *
     * @param $where
     * @return array
     */
    protected function searchData($where)
    {
        $keyowrd = $where["keyword"]['keyword'];
        $goods_data = $this->goodsModel::where('status', 0)
                                         ->where('title', 'like', "%{$keyowrd}%")
                                         ->SearchPrice($where['price'])
                                         ->orderBy('id', 'desc')->paginate(self::$page_limit);
        $category_ids = $goods_data->pluck('three_category')->toArray();
        $categorys = $this->goodsCategoryModel::whereIn('id', $category_ids)->where('status', 0)->get();
        $keyowrds = Redis::get('keyword');
        if($keyowrds != '') {
            $data = json_decode($keyowrds);
            array_push($data, $keyowrd);
        } else {
            $data[] = $keyowrd;
        }
        Redis::set('keyword', json_encode($data));
        return [
            'categorys' => $categorys,
            'goods' => $goods_data,
            'nav' => '搜索',
            'selected' => ''
        ];
    }
}
