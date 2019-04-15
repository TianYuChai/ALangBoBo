<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/15
 * Time: 15:40
 */
namespace App\Http\Services\home;


use App\Http\Models\admin\goods\BannerModel;
use App\Http\Models\admin\goods\goodsCategoryModel;

class IndexService extends BaseService
{
    public function entrance()
    {
        $categorys = $this->category();
        $banners = $this->banner();
        return [
            'categorys' => $categorys,
            'banners' => $banners
        ];
    }

    /**
     * 商品分类
     *
     * @return array
     */
    public function category()
    {
        $all_category = goodsCategoryModel::where([
            'status' => 0,
        ])->orderBy('sort', 'desc')->get();

        return infiniteCate($all_category);
    }

    /**
     * banner图
     *
     * @return mixed
     */
    public function banner()
    {
        return BannerModel::where([
            'status' => 1
        ])->orderBy('sort', 'desc')->get(['image_url', 'url', 'sort']);
    }
}
