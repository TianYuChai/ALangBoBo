<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/12
 * Time: 9:18
 */
namespace App\Http\Controllers\home;

use App\Http\Models\admin\goods\goodsCategoryModel;
use App\Http\Models\home\partTimeModel;
use App\Http\Models\home\partTimeSendModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Exception;

class parTimeListController extends BaseController
{
    public function __construct(partTimeModel $model,
                                goodsCategoryModel $categoryModel,
                                partTimeSendModel $partTimeSendModel)
    {
        $this->model = $model;
        $this->categoryModel = $categoryModel;
        $this->partTimeSendModel = $partTimeSendModel;
    }

    public function index()
    {
        $search_category = Input::get('category', '');
        $search_settle = Input::get('settle', '');
        $search_min_price = trim(Input::get('min_price', ''));
        $search_max_price = trim(Input::get('max_price', ''));
        $items = $this->model::SearchCategory($search_category)
                                ->SearchSettle($search_settle)
                                ->SearchPrice([$search_min_price, $search_max_price])->paginate(20);
        $categorys = $this->categoryModel::where([
            'status' => 0,
            'p_id' => 124
        ])->get();
        $settles = partTimeModel::$_SETTLE;
        return view('home.part_time_list', compact('items', 'categorys', 'settles'));
    }

    /**
     * 展示页
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $item = $this->model::where('id', $id)->first();
        if(Auth::guard('web')->check()) {
            $result = $this->partTimeSendModel::where('uid', Auth::guard('web')->user()->id)->first();
            if($result) {
                $item->whetSend = true;
            }
        }
        $categorys = $this->categoryModel::where([
            'status' => 0,
            'p_id' => 124
        ])->get();
        $settles = partTimeModel::$_SETTLE;
        dd($item->merchant);
        return view('home.part_time_show', compact('item', 'categorys', 'settles'));
    }

    /**
     * 用户投递
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function send($id)
    {
        try {
            $item = $this->model::where('id', intval($id))->first();
            if(!$item) {
                throw new Exception('请刷新重试');
            }
            $uid = Auth::guard('web')->user()->id;
            if($uid == $item->uid) {
                throw new Exception('不可投递自己发布的需求');
            }
            if($this->partTimeSendModel::where([
                'uid' => $uid,
                'pid' => intval($id)
            ])->exists()){
                throw new Exception('请勿重复投递');
            }
            $this->partTimeSendModel::create([
                'uid' => $uid,
                'pid' => intval($id)
            ]);
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }
}
