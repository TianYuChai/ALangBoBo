<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/5/26
 * Time: 18:59
 */
namespace App\Http\Controllers\admin\other;

use App\Http\Controllers\admin\BaseController;
use App\Http\Models\currency\UserModel;
use App\Http\Models\home\blackTimeModel;
use App\Http\Models\home\theBlackListModel;
use App\Http\Services\admin\Member\MemberService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;

class blackListController extends BaseController
{
    public function __construct(theBlackListModel $model,
                                blackTimeModel $timeModel,
                                UserModel $userModel)
    {
        $this->model = $model;
        $this->timeModel = $timeModel;
        $this->userModel = $userModel;
    }

    public function index()
    {
        $items = $this->model::orderBy('id', 'desc')->paginate(parent::$page_limit);
        $data = [
            'items' => $items,
            'black_count' => $items->count()
        ];
        return view('admin.other.black_list', compact('data'));
    }

    /**
     * 处理黑名单
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($id, Request $request, MemberService $memberService)
    {
        try {
            $text = trim($request->input('content', ''));
            if(!regularHaveSinoram($text)) {
                throw new Exception('请输入天数');
            }
            $time = Carbon::now()->modify('+'.intval($text).' days')->toDateTimeString();
            $res = $this->model::where('id', intval($id))->first();
            $res->status = 1;
            $res->result = '违法相关规定, 现已进行封停账号处理';
            $res->end_time = $time;
            $res->save();
            $item = $this->timeModel::where('gid', $res->gid)->first();
            if($item) {
                $item->time = Carbon::parse($item->time)->modify('+'.intval($text).' days')->toDateTimeString();
                $item->save();
            } else {
                $this->timeModel::create([
                    'gid' => $res->gid,
                    'time' => $time
                ]);
            }
            $item = $this->userModel::where('id', $res->gid)->first();
            if(in_array($item->categorys, [1, 2])) {
                $memberService->saelUpMemberGoods($item);
            }
            $item->status = 2;
            $item->save();
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }
    /**
     * 删除
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function del($id, MemberService $memberService)
    {
        try {
            $res = $this->model::where('id', intval($id))->first();
            $item = $this->userModel::where('id', $res->gid)->first();
            if(in_array($item->categorys, [1, 2])) {
                $memberService->stopMemberGoods($item);
            }
            $this->timeModel::where('gid', $res->gid)->delete();
            $res->delete();
            $item->status = 1;
            $item->save();
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }
}
