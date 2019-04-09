<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/8
 * Time: 14:22
 */
namespace App\Http\Services\admin\Goods;

use App\Http\Models\admin\goods\goodsCategoryAttributeModel;
use App\Http\Models\admin\goods\goodsCategoryModel;
use App\Http\Services\BaseService;
use Exception;

class goodsCategoryService extends BaseService
{
    /**
     * 输入处理
     *
     * @param $data
     * @return array
     * @throws Exception
     */
    public function messageFile($data)
    {
        $cate_name = trim($data['cate_name']);
        if(goodsCategoryModel::where('cate_name', $cate_name)->first()) {
            throw new exception('分类名称已存在');
        }
        $level = intval($data['level']);
        $category = goodsCategoryModel::where('id', $level)->first();
        $res = [
            'p_id' => empty($category) ? $level : intval($category->id),
            'level' => empty($category) ? 1 : intval($category->level) + 1,
            'cate_name' => $cate_name,
            'sort' => intval($data['sort']),
        ];

        //整理分类属性栏数据
        $cate_attribute = $this->cateAttributeFile($res['level'], $data['attribute']);

        return [
            'cate_data' => $res,
            'cate_attribute_data' => $cate_attribute
        ];
    }

    /**
     * 添加分类同时进行分类属性添加
     * @param $data
     */
    public function setMessage($data)
    {
        $category = goodsCategoryModel::create($data['cate_data']);
        $this->createAttribute($category->id, $data['cate_attribute_data']);
    }

    /**
     * 整理分类栏数据
     *
     * @param $type
     * @param $attribute
     * @return array
     */
    protected function cateAttributeFile($type, $attribute)
    {
        if($type != 2 || empty($attribute)) {
            return [];
        }
        $data = [];
        foreach ($attribute as $key => $value) {
            $items = explode(',', $value);
            foreach ($items as $item) {
                $data[] = [
                    'attribute_name' => trim($key),
                    'attribute_value' => $item
                ];
            }
        }
        return $data;
    }

    /**
     * 添加分类属性
     *
     * @param $cate_id
     * @param $data
     */
    protected function createAttribute($cate_id, $data)
    {
        if(!empty($data)) {
            foreach ($data as $key => $attribute_datum) {
                goodsCategoryAttributeModel::updateorcreate([
                    'cate_id' => $cate_id,
                    'attribute_name' => $attribute_datum['attribute_name'],
                    'attribute_value' => $attribute_datum['attribute_value']
                ],[
                    'cate_id' => $cate_id,
                    'attribute_name' => $attribute_datum['attribute_name'],
                    'attribute_value' => $attribute_datum['attribute_value']
                ]);
//                $data[$key]['cate_id'] = $cate_id;
//                $data[$key]['created_at'] = date('Y-m-d H:i:s', time());
//                $data[$key]['updated_at'] = date('Y-m-d H:i:s', time());
            }
//            goodsCategoryAttributeModel::insert($data);
        }
    }
}
