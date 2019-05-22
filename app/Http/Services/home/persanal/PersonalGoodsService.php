<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/5/22
 * Time: 21:22
 */
namespace App\Http\Services\home\persanal;
use App\Events\goods;
use App\Http\Models\admin\goods\goodsCategoryAttributeModel;
use App\Http\Services\home\BaseService;
use Exception;

class PersonalGoodsService extends BaseService
{
    const Tips = [
        'attribute' => '商品属性错误, 请重新选择'
    ];
    public function __construct(goodsCategoryAttributeModel $attributeModel)
    {
        parent::__construct();
        $this->attributeModel = $attributeModel;
    }

    public function dataFiltering($data)
    {
        if(isset($data['attribute']) && !empty($data['attribute'])) {
            $attributes = $this->filteringAttribute($data['attribute']);
        }
        $images = $this->filteringImg([$data['cover_img'], $data['rotation_chart']]);

    }

    /**
     * 商品属性处理
     *
     * @param $data
     * @return mixed
     * @throws Exception
     */
    protected function filteringAttribute($data)
    {
        if(is_array($data)) {
            $res = [];
            foreach ($data as $k => $v) {
                foreach ($v as $vv) {
                    $res[] = $vv;
                }
            }
            try {
                $data = $this->attributeModel::whereIn('id', $res)->get(['attribute_name', 'attribute_value']);
               if($data->isEmpty()) {
                   throw new Exception(self::Tips['attribute']);
               }
               return $data->groupBy('attribute_name');
            } catch (Exception $e) {
                throw new Exception(self::Tips['attribute']);
            }
        }
    }

    /**
     * 处理商品图片
     *
     * @param $data
     * @return array
     */
    protected function filteringImg($data)
    {
        $result[] = [
            'name' => $data[0],
            'type' => 1
        ];
        foreach ($data[1] as $datum) {
            $result[] = [
                'name' => $datum,
                'type' => 2
            ];
        }
        return $result;
    }
}