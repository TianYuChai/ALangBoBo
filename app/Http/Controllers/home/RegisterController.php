<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/15
 * Time: 18:14
 */
namespace App\Http\Controllers\home;

use App\Http\Models\currency\UserModel;
use App\Http\Requests\home\RegisterRequest;
use App\Http\Services\home\RegisterService;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use Exception;
use shortMessage;
use faceReacognition;

class RegisterController extends BaseController
{
    public function index()
    {
        return view('home.register');
    }

    public function create(RegisterRequest $request, RegisterService $registerService)
    {
        try {
            $data = $registerService->dataFiltering($request);
            $user = $registerService->addData($data);
            return $this->ajaxReturn([
                'info' => '注册成功',
                'data' => [
                    'account' => $user->account,
                    'category' => $user->category
                ],
                'status' => 200
            ], 200);
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => 100
            ], 510);
        }
    }
    /**
     * 验证注册内容是否可用
     * @account 用户账户
     * @name 姓名是否使用
     * @card 身份证id
     * @number 手机号
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifivWhetExist(Request $request)
    {
        try {
            $data = [
                'account' => trim($request->account),
                'name' => trim($request->name),
                'card' => trim($request->id),
                'number' => trim($request->mobile)
            ];
            $where = array_unique(array_diff($data, array("")));
            if(!empty($where)) {
                if($where['card'] != '' || $where['name'] != '') {
                    $category = $request->category;
                    if($where['card'] != '') {
                        $query = UserModel::where('card', $where['card']);
                    } else {
                        $query = UserModel::where('name', $where['name']);
                    }
                    $item = $query->where('category', $category)->first();
                } else {
                    $item = UserModel::where($where)->where('status', '!=', 3)->first();
                }
                if($item) {
                   throw new Exception('已存在');
                }
                return $this->ajaxReturn();
            }
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => 100
            ], 510);
        }
    }
}
