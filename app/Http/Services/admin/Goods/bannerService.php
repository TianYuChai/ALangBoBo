<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/12
 * Time: 10:49
 */
namespace App\Http\Services\admin\Goods;

use App\Http\Models\admin\goods\BannerModel;
use App\Http\Services\BaseService;
use Exception;
use FileUpload;

class bannerService extends BaseService
{
    private $model;

    public function __construct()
    {
        $this->model = BannerModel::class;
    }
    /**
     * 数据过滤
     * 1.过滤用户提交的域名地址，确认用户提交地址是可访问
     * 2.过滤用户提交的上下架时间, 确认上架时间大于当前时间,也小于下架时间
     * 3.过滤用户提交的图片地址，确认用户提交的图片地址是从本站上传
     * @param $data
     * @return array
     * @throws Exception
     */
    public function dataProcessing($data)
    {
        $validator_url = verificationUrl($data['url']);
        if(!$validator_url) {
            throw new Exception('链接地址不可使用, 请填写可用地址');
        }

        $time = explode(' - ', $data['section_time']);
        list($start_time, $end_time) = $time;
        if($start_time < getTime('ymd')) {
            throw new Exception('上架时间不可小于当前操作时间');
        }
        if(strtotime($start_time) > strtotime($end_time)) {
            throw new Exception('下架时间不可小于上架时间');
        }

        $exists_file = FileUpload::exists('image', $data['banner_image_url']);
        if(!$exists_file) {
            throw new Exception('轮播图片并非本站图, 不可使用');
        }

        return [
            'url' => $data['url'],
            'start_time' => $start_time,
            'end_time' => $end_time,
            'sort' => intval($data['sort']),
            'image_url' => $data['banner_image_url'],
        ];
    }

    /**
     * 存入数据库
     *
     * @param $data
     */
    public function depositInDb($data)
    {
        $this->model::create($data);
    }
}
