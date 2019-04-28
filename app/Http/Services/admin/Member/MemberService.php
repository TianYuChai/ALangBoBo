<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/2
 * Time: 17:15
 */
namespace App\Http\Services\admin\Member;

use App\Http\Models\admin\RegisterAuditingModel;
use App\Http\Models\currency\UserModel;
use App\Http\Services\admin\BaseService;
use Exception;


class MemberService extends BaseService
{
    /**
     * 校验会员是否可用
     *
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function checkMember($id)
    {
         $item = UserModel::find($id);
         if(!$item) {
             throw new Exception('数据有误, 不存在此数据');
         }
         return $item;
    }

    /**
     * 校验过审会员是否可用
     *
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function checkMemberStatus($id)
    {
        $item = $this->checkMember($id);
        if($item->status != 0) {
            throw new Exception('不符合过审条件');
        }
        return $item;
    }

    /**
     * 驳回用户提交的注册申请
     * 已审核规划到未审核中
     * 查询是否审核，则去审核记录中查看
     * 存在记录则审核过，不存在则未审核。
     * @param $data
     * @param $text
     * @throws Exception
     */
    public function handleRejectReason($data, $text)
    {
        if(!$text['reject_reason']) {
            throw new Exception('请填写驳回原因');
        }
        RegisterAuditingModel::create([
            'uid' => intval($data->id),
            'reject' => trim($text['reject_reason'])
        ]);
    }

    /**
     * 过滤用户数据
     * 判断用户数据是否存在, 然后再去判断密文是否合法
     * @param $id
     * @param $data
     * @throws Exception
     */
    public function passFilter($id, $data)
    {
        $this->checkMember($id);
        if(!regularHaveSinoram($data['pass'])) {
            throw new Exception('密文中含有中文');
        }
        $str_len = stringLen($data['pass']);
        if($str_len < 6 || $str_len > 12) {
            throw new Exception('密文长度超出限制');
        }
    }

    /**
     * 修改密码
     * @param $id
     * @param $data
     */
    public function editPass($id, $data)
    {
        UserModel::where('id', intval($id))->update([
            'password' => bcrypt($data['pass'])
        ]);
    }

    /**
     * 封停账户，预留，
     * 等商品表，进行同步封停
     * @param $data
     */
    public function saelUpMemberGoods($data)
    {
        $data->status = 2;
        $data->save();
    }

    /**
     * 启用账户，预留
     * 等商品表，同步启用
     * @param $data
     */
    public function stopMemberGoods($data)
    {
        $data->status = 1;
        $data->save();
    }

    /**
     * 根据类别生成商家编号
     *
     * @param $category_id
     * @return string
     */
    public function merchNumber($category_id)
    {
        $count = UserModel::where([
            'category' => $category_id,
            'status' => 1
        ])->count();
        return $category_id == 1 ? 'busi' : 'pers' . sprintf("%04d", $count);
    }
}
