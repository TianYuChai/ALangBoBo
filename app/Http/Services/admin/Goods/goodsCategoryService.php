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
use App\Http\Services\admin\BaseService;
use Exception;
use Prophecy\Exception\Prediction\NoCallsException;

class goodsCategoryService extends BaseService
{
    /**
     * 输入处理
     *
     * @param $data
     * @return array
     * @throws Exception
     */
    public function messageFile($id, $data)
    {
        $cate_name = trim($data['cate_name']);
        $this->ifCategory($cate_name, $id);

        $res = [
            'p_id' => isset($data['level']) ? intval($data['level']) : "",
            'cate_name' => $cate_name,
            'sort' => intval($data['sort']),
        ];
        //整理分类属性栏数据
        $cate_attribute = $this->cateAttributeFile($data['attribute']);
        return [
            'cate_data' => $res,
            'cate_attribute_data' => $cate_attribute
        ];
    }

    /**
     * 添加分类同时进行分类属性添加
     *
     * @param $data
     */
    public function setMessage($data)
    {
        $pcategory = goodsCategoryModel::where('id', $data['cate_data']['p_id'])->first();
        if(!$pcategory && $data['cate_data']['p_id'] != '0') {
            throw new Exception('信息错误');
        }
        $data['cate_data']['p_id'] = empty($pcategory) ? $data['cate_data']['p_id'] : intval($pcategory->id);
        $data['cate_data']['level'] = empty($pcategory) ? 1 : intval($pcategory->level) + 1;
        $category = goodsCategoryModel::create($data['cate_data']);
        if($category->level == 2) {
            $this->createAttribute($category->id, $data['cate_attribute_data']);
        }
    }

    /**
     * 更新分类同时进行分类属性更新
     *
     * @param $id
     * @param $data
     */
    public function updateMessage($id, $data)
    {
        unset($data['cate_data']['p_id']);
        $category = goodsCategoryModel::where('id', intval($id))->first();
        $category->cate_name = $data['cate_data']['cate_name'];
        $category->sort = $data['cate_data']['sort'];
        $category->save();
        if($category->level == 2) {
            $this->createAttribute($category->id, $data['cate_attribute_data']);
        }
    }

    /**
     * 整理分类栏数据
     *
     * @param $attribute
     * @return array
     */
    protected function cateAttributeFile($attribute)
    {
        if(empty($attribute)) {
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
                goodsCategoryAttributeModel::updateOrCreate([
                    'cate_id' => $cate_id,
                    'attribute_name' => $attribute_datum['attribute_name'],
                    'attribute_value' => $attribute_datum['attribute_value']
                ],[
                    'cate_id' => $cate_id,
                    'attribute_name' => $attribute_datum['attribute_name'],
                    'attribute_value' => $attribute_datum['attribute_value'],
                    'status' => 0
                ]);
            }
        }
    }

    /**
     * 根据节点去更新对应的子节点
     *
     * 根据上一层的节点去获取对应的子节点
     * 在子节点不为空的情况下去更新
     * @param $id
     * @param $status
     */
    public function banKai($id, $status)
    {
        $items = goodsCategoryModel::get(['id','p_id']);
        $subClass_ids = array_flatten(
            infiniteCate($items, $id, false)
        );
        if(!empty($subClass_ids)) {
            goodsCategoryModel::whereIn('id', $subClass_ids)->update(['status' => $status]);
        }
    }

    /**
     * 过滤条件组成
     *
     * @param $cate_name
     * @param int $id
     * @throws Exception
     */
    public function ifCategory($cate_name, $id = '')
    {
        if(goodsCategoryModel::where('cate_name', $cate_name)->where('id', '!=', $id)->exists()) {
            throw new exception('分类名称已存在');
        }
    }
}
