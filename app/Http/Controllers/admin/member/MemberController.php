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
        $query = $this->makeQuery(new UserModel());
        $items = $query->orderBy('created_at', 'desc')->paginate(parent::$page_limit);
        return view('admin.member.index', compact('items'));
    }
}
