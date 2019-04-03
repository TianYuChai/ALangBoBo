<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/3
 * Time: 16:50
 */
namespace App\Http\Controllers\admin\member;

use App\Http\Controllers\admin\BaseController;
use App\Http\Models\admin\RegisterAuditingModel;
use Illuminate\Http\Request;
use Exception;

class MemberRejectController extends BaseController
{
    public function makeQuery($query, $data)
    {
        return $query->SearchUser($data['user']);
    }

    /**
     * 驳回记录查询
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = trim($request->input('account', ''));
        $query = $this->makeQuery(new RegisterAuditingModel(), [
            'user' => $user
        ]);
        $items = $query->orderBy('id', 'desc')->paginate(parent::$page_limit);
        $data = [
            'items' => $items,
            'select_account' => $user
        ];
        return view('admin.member.reject_list', compact('data'));
    }

    /**
     * 取消驳回操作
     * 
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel($id)
    {
        try {
            $item = RegisterAuditingModel::findOrFail($id);
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
