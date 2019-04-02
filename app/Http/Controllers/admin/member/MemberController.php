<?php

namespace App\Http\Controllers\admin\member;

use App\Http\Controllers\admin\BaseController;
use App\Http\Models\admin\BackstageModel;
use App\Http\Models\currency\UserModel;

class MemberController extends BaseController
{
    /**
     * 用户管理列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function makeQuery($query)
    {
        return $query;
    }
    public function index()
    {
//        dd(UserModel::create([
//            'account' => '研发1',
//            'password' => bcrypt('admin123'),
//            'category' => 0,
//            'name' => '柴天宇',
//            'card' => '341124199411203811',
//            'number' => '1395505240',
//            'type' => 1,
//            'status' => 1
//        ]));
        $query = $this->makeQuery(new UserModel());
        $user_count = $query->count(); //会员统计
        $items = $query->orderBy('created_at', 'desc')->paginate(parent::$page_limit);
        $category = UserModel::$_CATEGORY; //商户类别
        $status = UserModel::$_STATUS; //账户状态
        return view('admin.member.index', compact(
            'items', 'user_count', 'category', 'status'
        ));
    }
}
