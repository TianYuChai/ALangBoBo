<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/13
 * Time: 14:26
 */
namespace App\Http\Controllers\admin\member;

use App\Http\Controllers\admin\BaseController;
use App\Http\Models\currency\UserModel;
use App\Http\Models\home\personal\CancellModel;
use App\Http\Services\admin\Member\MemberService;
use Input;
use Exception;

class MemberCancelController extends BaseController
{

    public function makeQuery($query)
    {
        $account = trim(Input::get('account', ''));
        return $query->SearchAccount($account);
    }

    public function index()
    {
        $query = $this->makeQuery(new CancellModel());
        $items = $query->orderBy('id', 'desc')->paginate(parent::$page_limit);
        $data = [
            'items' => $items,
            'cancel_count' => $items->count()
        ];
        return view('admin.member.cancel.cancel', compact('data'));
    }

    /**
     * 封停用户
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function agree($id, MemberService $memberService)
    {
        try {
            $item = CancellModel::where('id', intval($id))->first();
            UserModel::where('id', intval($item->uid))->update(['status' => 3]);
            $memberService->saelUpMemberGoods($item);
            $item->delete();
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => 510
            ], 510);
        }
    }
}
