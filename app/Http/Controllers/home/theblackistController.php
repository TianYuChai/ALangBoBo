<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/5/26
 * Time: 15:24
 */
namespace App\Http\Controllers\home;

use App\Http\Models\currency\MerchantModel;
use App\Http\Models\currency\UserModel;
use App\Http\Models\home\theBlackListModel;
use Illuminate\Http\Request;
use Exception;

class theblackistController extends BaseController
{
    public function index()
    {
        $merchants = theBlackListModel::where([
            'status' => 1,
            'type' => 0
        ])->paginate(parent::$page_limits);
        $users = theBlackListModel::where([
            'status' => 1,
            'type' => 1
        ])->paginate(parent::$page_limits);
        $data = [
            'merchants' => $merchants,
            'users' => $users
        ];
        return view('home.theBlacklist', compact('data'));
    }

    /**
     * 申请商家黑名单
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function merchantStore(Request $request)
    {
        try {
            $name = trim($request->name);
            $why = trim($request->why);
            $item = MerchantModel::where('shop_name', $name)->first();
            if(!$item) {
                throw new Exception('无此商家, 请核实商家名称后进行操作');
            }
            if($item->user->status != 1) {
                throw new Exception('已被封禁，无需重复操作');
            }
            $uid = $request->user('web')->id;
            if($item->uid == $uid) {
                throw new Exception('错误操作，无法举报自己');
            }
            theBlackListModel::create([
                'gid' => $item->uid,
                'uid' => $uid,
                'why' => $why,
                'type' => 0
            ]);
            return $this->ajaxReturn([
                'status' => 200,
                'info' => '申请成功'
            ], 200);
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }

    /**
     * 举报用户
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userStore(Request $request)
    {
        try {
            $name = trim($request->name);
            $why = trim($request->why);
            $item = UserModel::where('account', $name)->first();
            if(!$item) {
                throw new Exception('用户不存在，请选择真实用户');
            }
            if($item->status != 1) {
                throw new Exception('已被封禁，无需重复操作');
            }
            $uid = $request->user('web')->id;
            if($item->id == $uid) {
                throw new Exception('错误操作，无法举报自己');
            }
            theBlackListModel::create([
                'gid' => $item->id,
                'uid' => $uid,
                'why' => $why,
                'type' => 1
            ]);
            return $this->ajaxReturn([
                'status' => 200,
                'info' => '申请成功'
            ], 200);
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }
    /**
     * 验证商家是否存在
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function selectShop(Request $request)
    {
        try {
            $name = trim($request->name);
            $item = MerchantModel::where('shop_name', $name)->first();
            if(!$item) {
                   throw new Exception('无此商家, 请核实商家名称后进行操作');
            }
            if($item->user->status != 1) {
                throw new Exception('已被封禁，无需重复操作');
            }
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }

    /**
     * 验证用户
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function selectUser(Request $request)
    {
        try {
            $name = trim($request->name);
            $item = UserModel::where('account', $name)->first();
            if(!$item) {
                throw new Exception('请输入正确用户账号');
            }
            if($item->status != 1) {
                throw new Exception('已被封禁，无需重复操作');
            }
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' =>510,
                'info' => $e->getMessage()
            ], 510);
        }
    }
}
