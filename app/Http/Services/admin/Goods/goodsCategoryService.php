<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/8
 * Time: 14:22
 */
namespace App\Http\Services\admin\Goods;

use App\Http\Models\admin\goods\goodsCategoryModel;
use App\Http\Services\BaseService;
use Exception;

class goodsCategoryService extends BaseService
{
    /**
     * 输出处理
     *
     * @param $data
     * @return array
     */
    public function messageFile($data)
    {
        $level = intval($data['level']);
        $category = goodsCategoryModel::where('id', $level)->first();
        $res = [
            'p_id' => empty($category) ? $level : intval($category->id),
            'level' => empty($category) ? 1 : intval($category->level) + 1,
            'cate_name' => trim($data['cate_name']),
            'sort' => intval($data['sort']),
        ];

        //分类属性栏数据,条件：二级分类
        $cate_attribute = [];

        if($res['level'] == 2) {
            $attribute = $data['attribute'];
            if(!empty($attribute)) {
                dd($attribute);
            }
        }
        return [
            'cate_data' => $res,
            'cate_attribute_data' => $cate_attribute
        ];
    }

    public function setMessage($data)
    {
        $category = goodsCategoryModel::create($data['cate_data']);
        
    }
}
