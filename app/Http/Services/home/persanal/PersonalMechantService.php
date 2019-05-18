<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/5/18
 * Time: 22:00
 */
namespace App\Http\Services\home\persanal;

use App\Http\Models\admin\RegisterAuditingModel;
use App\Http\Models\currency\MerchantModel;
use App\Http\Models\currency\UserModel;
use App\Http\Services\home\BaseService;
use Illuminate\Support\Facades\Auth;
use FileUpload;
use Exception;
use Illuminate\Support\Facades\DB;

class PersonalMechantService extends BaseService
{
    protected $model;
    protected $userId;
    protected $userModel;
    protected $user;
    protected $registerAuditingModel;
    public function __construct(MerchantModel $model, UserModel $userModel, RegisterAuditingModel $registerAuditingModel)
    {
        parent::__construct();
        $this->model = $model;
        $this->userModel = $userModel;
        $this->userId =  Auth::guard('web')->user()->id;
        $this->user = Auth::guard('web')->user();
        $this->registerAuditingModel = $registerAuditingModel;
    }

    /**
     * 开始
     * @param $data
     * @return array
     * @throws Exception
     */
    public function start($data)
    {
        $category = intval($data['category']);
        switch ($category) {
            case 1:
                $result = $this->verifiEnter($data);
            break;
            case 2:
                $result = $this->verifiPersonal($data);
            break;
        }
        $result['shop_name'] = trim($data['shopName']);
        $result['credit_code'] = trim($data['shehuiDaima']);
        $result['category'] = $category;
        $result['status'] = 0;
        $result['uid'] = $this->userId;
        return $result;
    }

    /**
     * 添加更新数据
     *
     * @param $data
     */
    public function create($data)
    {
        $this->userModel::where('id', $this->userId)->update(['category' => $data['category']]);
        $this->model::updateorcreate([
            'uid' => $data['uid']
        ], $data);
        if($this->user->registerauditing) {
            $this->registerAuditingModel::destroy($this->user->registerauditing['id']);
        }
    }
    /**
     * 验证企业商户
     *
     * @param $data
     * @return array
     * @throws Exception
     */
    protected function verifiEnter($data)
    {
        $result = $this->cadrImage($data);
        if(!FileUpload::exists('image', $data['yyzz'])) {
            throw new Exception('营业执照图错误, 请重新上传');
        }
        if($data['food'] != "" && !FileUpload::exists('image', $data['food'])) {
            throw new Exception('食品行业证件图错误, 请重新上传');
        }
        if($data['mrlf'] != "" && !FileUpload::exists('image', $data['mrlf'])) {
            throw new Exception('美容或理发行业图错误, 请重新上传');
        }
        if($data['qt'] != "" && !FileUpload::exists('image', $data['qt'])) {
            throw new Exception('其它行业证件图错误, 请重新上传');
        }
        $result['bus_license'] = $data['yyzz'];
        $result['food_industry'] = $data['food'] !='' ? $data['food'] : "";
        $result['hairdressing'] = $data['mrlf'] !='' ? $data['mrlf'] : "";
        $result['other'] = $data['qt'] !='' ? $data['qt'] : "";
        return $result;
    }

    /**
     * 验证个人商户
     *
     * @param $data
     * @return array
     * @throws Exception
     */
    public function verifiPersonal($data)
    {
        $result = $this->cadrImage($data);
        if(!FileUpload::exists('image', $data['zuopin'])) {
            throw new Exception('个人证件或作品图错误, 请重新上传');
        }
        $result['personal'] = $data['zuopin'];
        return $result;
    }

    /**
     * 验证身份证
     *
     * @param $data
     * @return array
     * @throws Exception
     */
    protected function cadrImage($data)
    {
        if(!FileUpload::exists('image', $data['zheng'])) {
            throw new Exception('身份证正面图错误, 请重新上传');
        }
        if(!FileUpload::exists('image', $data['fan'])) {
            throw new Exception('身份证反面图错误, 请重新上传');
        }
        return [
            'card_positive' => $data['zheng'],
            'card_opposite' => $data['fan'],
            'shop_name' => trim($data['shopName']),
            'credit_code' => trim($data['shehuiDaima'])
        ];
    }
}