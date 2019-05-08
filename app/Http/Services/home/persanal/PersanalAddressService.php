<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/5/7
 * Time: 22:12
 */
namespace App\Http\Services\home\persanal;

use App\Http\Models\home\personal\AddressModel;
use App\Http\Services\home\BaseService;
use Exception;

class PersanalAddressService extends BaseService
{
    public function __construct(AddressModel $addressModel)
    {
        parent::__construct();
        $this->model = $addressModel;
    }

    /**
     * 地址数据处理入口
     *
     * 根据类别不同，进行不同的数据处理过程，但是，相同部分的数据可以进行数据处理。
     *
     * @param $data
     * @return array
     * @throws Exception
     */
    public function addressFilter($data)
    {
        $res = $this->publicAddress($data);
        if($data['type'] == "receiveForm") {
            $res = $this->receivingAddress($res, $data);
        } else {
            $res = $this->shippingAddress($res, $data);
        }
        return $res;
    }

    /**
     * 数据添加
     *
     * @param $data
     */
    public function create($data)
    {
        $this->model::create($data);
    }

    /**
     * 更新地址状态
     *
     *
     * @param $status
     */
    public function handleStatus($status)
    {
        $item = $this->model::where([
            'uid' => $this->userId,
            'category' => 900,
            'status' => 703
        ])->first();
        if($item){
            $item->status = $status == 700 ? 701 : 700;
            $item->save();
        } else {
            $this->model::where([
                'uid' => $this->userId,
                'category' => 900,
                'status' => $status
            ])->update(['status' => 699]);
        }
    }
    /**
     * 公用信息处理
     *
     * @param $data
     * @return array
     * @throws Exception
     */
    public function publicAddress($data)
    {
        if($this->model::where(['uid' => $this->userId, 'category' => $data['type'] == "sendForm" ? 900 : 800])->count() >= 20) {
            throw new Exception('收货地址已超出可添加数量');
        }
        $code = $this->code($data['code']);
        return [
            'uid' => $this->userId,
            'address' => $data['eprovince'] .'/'. $data['city'] .'/'. $data['district'],
            'detailed' => $data['detailed'],
            'code' => $code ?? "",
            'contacts' => $data['contacts'],
            'number' => $data['number'],
        ];
    }

    /**
     * 处理收货地址
     *
     * @param $res
     * @param $data
     * @return array
     */
    protected function receivingAddress($res, $data)
    {
        $status = $data['status'] ? 702 : 699;
        if($status == 702) {
            $this->model::where([
                'uid' => $this->userId,
                'category' => 800,
                'status' => 702
            ])->update(['status' => 699]);
        }
        return array_merge($res, [
            'category' => 800,
            'status' => $data['status'] ? 702 : 699
        ]);
    }

    /**
     * 处理发货地址
     *
     * @param $res
     * @param $data
     * @return array
     */
    protected function shippingAddress($res, $data)
    {
        return array_merge($res, [
            'tel' => $data['tel'][0] . '-' . $data['tel'][1] . '-' . $data['tel'][2],
            'corname' => $data['corname'],
            'category' => 900,
            'status' => 699
        ]);
    }

    /**
     * 处理邮政编码
     *
     * @param $code
     * @return bool|int|string
     */
    protected function code($code)
    {
        if(isset($code) && is_numeric($code)) {
            if(strlen($code) > 6) {
                $code = substr($code, 0, 5);
            } else {
                $code = $code;
            }
            return $code;
        }
    }
}
