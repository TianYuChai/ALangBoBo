<?php

namespace App\Http\Controllers\admin\member;

use App\Http\Controllers\admin\BaseController;
use App\Http\Models\admin\BackstageModel;
use App\Http\Models\currency\UserModel;
use App\Http\Services\admin\Member\MemberService;
use Illuminate\Http\Request;
use Exception;

class MemberController extends BaseController
{
    /**
     * 用户管理列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function makeQuery($query, $data)
    {
        return $query->SearchTime($data['section_time'])
                     ->SearchAccount($data['account'])
                     ->SearchCategory($data['category'])
                     ->SearchStatus($data['status']);
    }

    /**
     * 用户管理
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $section_time = trim($request->input('section_time', ''));
        $account = trim($request->input('account', ''));
        $category = trim($request->input('category', ''));
        $status = trim($request->input('status', ''));
        $query = $this->makeQuery(new UserModel(), [
            'section_time' => $section_time,
            'account' => $account,
            'category' => $category,
            'status' => $status,
        ]);
        $items = $query->orderBy('created_at', 'desc')->paginate(parent::$page_limit);
        $data = [
            'items' => $items,
            'user_count' => $query->count(),
            'category' => UserModel::$_CATEGORY, //商户类别
            'status' => UserModel::$_STATUS, //账户状态
            'select_section_time' => $section_time, //搜索时间
            'select_account' => $account, //搜索账户名称
            'select_category' => $category, //搜索类别
            'select_status' => $status, //搜索状态
        ];
        return view('admin.member.index', compact('data'));
    }

    /**
     * 修改用户密码
     * @param $id
     * @param Request $request
     * @param MemberService $memberService
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit_pass($id, Request $request, MemberService $memberService)
    {
        try{
            $memberService->passFilter($id, $request);
            $memberService->editPass($id, $request);
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => 510
            ], 510);
        }
        return $this->ajaxReturn();
    }
    /**
     * 会员过审
     * 为后期业务扩展未和驳回合并成一个函数
     *
     * @param $id
     * @param MemberService $memberService
     * @return \Illuminate\Http\JsonResponse
     */
    public function adopt($id, MemberService $memberService)
    {
        try{
            $item = $memberService->checkMemberStatus($id);
            $item->status = 1;
            $item->save();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => 510
            ], 510);
        }
        return $this->ajaxReturn();
    }

    /**
     * 用户审核驳回
     *
     * @param $id
     * @param Request $request
     * @param MemberService $memberService
     * @return \Illuminate\Http\JsonResponse
     */
    public function reject($id, Request $request, MemberService $memberService)
    {
        try{
            $item = $memberService->checkMemberStatus($id);
            $memberService->handleRejectReason($item, $request);
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => 510
            ], 510);
        }
        return $this->ajaxReturn();
    }
}
