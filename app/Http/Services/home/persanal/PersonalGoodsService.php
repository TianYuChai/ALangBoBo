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
use App\Http\Models\goods\goodsAttributeModel;
use App\Http\Models\goods\goodsImgModel;
use App\Http\Models\goods\GoodsModel;
use App\Http\Models\home\personal\AddressModel;
use App\Http\Services\home\BaseService;
use Exception;
use function PHPSTORM_META\type;

class PersonalGoodsService extends BaseService
{
    const Tips = [
        'attribute' => '商品属性错误, 请重新选择',
        'presell_time' => '预售时间不能小于当前时间'
    ];
    public function __construct(goodsCategoryAttributeModel $attributeModel,
                                AddressModel $addressModel, GoodsModel $goodsModel,
                                goodsAttributeModel $goodsAttributeModel, goodsImgModel $goodsImgModel)
    {
        parent::__construct();
        $this->attributeModel = $attributeModel;
        $this->addressModel = $addressModel;
        $this->goods = $goodsModel;
        $this->goodsAttribute = $goodsAttributeModel;
        $this->goodsImg = $goodsImgModel;
    }

    public function dataFiltering($data)
    {
        if(isset($data['attribute']) && !empty($data['attribute'])) {
            $attributes = $this->filteringAttribute($data['attribute']);
        }
        $images = $this->filteringImg([$data['cover_img'], $data['rotation_chart']]);
        $address_id = $this->fileteringAddress($data['address']);
        if(!empty($data['presell_time']) && $data['presell_time'] < getTime('ymd')) {
            throw new Exception(self::Tips['presell_time']);
        }
        return [
            'goods' => [
                'title' => trim($data['title']),
                'uid' => $this->userId,
                'main_category' => intval($data['category']['0']),
                'sub_category' => intval($data['category']['1']),
                'three_category' => isset($data['category']['2']) ? intval($data['category']['2']) : '',
                'nav_category' => intval($data['nav_category']),
                'address' => intval($address_id),
                'total_fee' => $data['total_price'],
                'cost_fee' => $data['cost_price'],
                'satic_fee' => $data['satis_price'],
                'delivery_fee' => !empty($data['delivery_price']) ? $data['delivery_price'] : '',
                'free_fee' => !empty($data['free_shipping']) ? $data['free_shipping'] : '',
                'stock' => intval($data['stock']),
                'new_goods' => isset($data['new_products']) ? intval($data['new_products']) : 0,
                'content' => isset($data['content']) ? $data['content'] : '',
                'presell_time' => isset($data['presell_time']) ? $data['presell_time'] : ''
            ],
            'attribute' => isset($attributes) ? $attributes : '',
            'images' => $images
        ];
    }

    /**
     * 添加数据
     *
     * @param $data
     */
    public function create($data)
    {
        $item = $this->goods::create($data['goods']);
        if($item) {
            $this->createAttribute($item->id, $data['attribute']);
            $this->createImg($item->id, $data['images']);
        }
    }

    /**
     * 更新数据
     *
     * @param $data
     */
    public function update($id, $data)
    {
        $number = $data['goods']['stock'];
        $item = $this->goods::where([
            'id' => intval($id),
            'uid' => $this->userId
        ])->first();
        $stock = bcsub($item->stock, $item->sold) > $number ?
                    bcsub($item->stock, bcsub(bcsub($item->stock, $item->sold), $number)) :
                    bcadd($item->stock, bcsub($number, bcsub($item->stock, $item->sold)));
        $data['goods']['stock'] = intval($stock);
        $item->update($data['goods']);
        $this->createAttribute($id, $data['attribute']);
        $this->updateImg($id, $data['images']);
    }

    /**
     * 添加商品属性
     *
     * @param $id
     * @param $data
     */
    protected function createAttribute($id, $data)
    {
        if(!empty($data)) {
            $attributes = [];
            foreach ($data as $value) {
                $attributes[] =[
                    'gid' => $id,
                    'name' => $value['attribute_name'],
                    'value' => $value['attribute_value'],
                    'created_at' => getTime(),
                    'updated_at' => getTime()
                ];
            }
            $this->goodsAttribute::insert($attributes);
        }
    }

    /**
     * 添加商品图片
     *
     * @param $id
     * @param $data
     */
    protected function createImg($id, $data)
    {
        if(!empty($data) && is_array($data)) {
            data_set($data, '*.gid', $id);
            data_set($data, '*.created_at', getTime());
            data_set($data, '*.updated_at', getTime());
            $this->goodsImg::insert($data);
        }
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
               return $data->toArray();
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
        if(!empty($data) && is_array($data)) {
            $result[] = [
                'img' => $data[0],
                'type' => 1
            ];
            foreach ($data[1] as $datum) {
                $result[] = [
                    'img' => $datum,
                    'type' => 2
                ];
            }
            return $result;
        }
    }

    /**
     * 处理地址信息
     * 未选择发货地址，则展示默认发货地址
     * @param $data
     * @return mixed
     * @throws Exception
     */
    protected function fileteringAddress($data)
    {
        if(!isset($data) || $data == '') {
            $item = $this->addressModel::where([
                'uid' => $this->userId,
                'category' => 900
            ])->where('status', 700)->orWhere('status', 703)->first();
            if(!$item) {
                throw new Exception('请先填写发货地址信息或选择默认发货地址');
            }
            $address_id = $item->id;
        } else {
            $address_id = $data;
        }
        return $address_id;
    }

    /**
     * 更新图片数据
     *
     * @param $id
     * @param $data
     */
    protected function updateImg($id, $data)
    {
        if (!empty($data) && is_array($data)) {
            $item = $this->goodsImg::where('gid', intval($id))->get(['img'])->toArray();
            $imgs = array_flatten($item);
            foreach ($data as $k => $v) {
                if(in_array($v['img'], $imgs)) {
                    unset($data[$k]);
                }
            }
            $this->createImg($id, $data);
        }
    }
}
