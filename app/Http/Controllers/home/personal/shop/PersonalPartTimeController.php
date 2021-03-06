<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/11
 * Time: 16:31
 */
namespace App\Http\Controllers\home\personal\shop;

use App\Http\Controllers\admin\BaseController;
use App\Http\Models\admin\goods\goodsCategoryModel;
use App\Http\Models\home\partTimeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;

class PersonalPartTimeController extends BaseController
{
    const ROUTE = HOME_PERSONAL_SHOP;
    /*兼职工*/
    public function __construct(partTimeModel $model)
    {
       $this->middleware(function ($request, $next) use($model) {
           if(Auth::guard('web')->check()) {
               $this->user = Auth::guard('web')->user();
           }
           $this->model = $model;
           return $next($request);
       });
    }

    public function index()
    {
        $items = $this->model::where('uid', $this->user->id)->paginate(parent::$page_limit);
        $goodsCategorys = goodsCategoryModel::where([
            'p_id' => 124,
            'status' => 0
        ])->get();
        $settle = partTimeModel::$_SETTLE;
        return view(self::ROUTE . 'part_time', compact('items', 'goodsCategorys', 'settle'));
    }

    /**
     * 添加内容
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
       try {
            $this->model::create([
                'uid' => $this->user->id,
                'title' => trim($request->title),
                'category_id' => $request->category,
                'image' => $request->cover_img,
                'money' => bcmul(trim($request->total_price), 100),
                'settle' => $request->settle,
                'time' => $request->time,
                'the_time' => $request->the_time,
                'describe' => trim($request->describe),
                'content' => $request->input('content')
            ]);
            return $this->ajaxReturn();
       } catch (Exception $e) {
           return $this->ajaxReturn([
               'status' => 510,
               'info' => $e->getMessage()
           ], 510);
       }
    }

    /**
     * 修改展示数据
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $item = $this->model::find($id);
        $goodsCategorys = goodsCategoryModel::where([
            'p_id' => 19,
            'status' => 0
        ])->get();
        $settle = partTimeModel::$_SETTLE;
        return view(self::ROUTE .'part_time_edit', compact('item', 'goodsCategorys', 'settle'));
    }

    /**
     * 修改数据
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        try{
            $this->model::where([
                'id' => $id,
                'uid' => $this->user->id
            ])->update([
                'title' => trim($request->title),
                'category_id' => $request->category,
                'image' => $request->cover_img,
                'money' => bcmul(trim($request->total_price), 100),
                'settle' => $request->settle,
                'time' => $request->time,
                'the_time' => $request->the_time,
                'describe' => trim($request->describe),
                'content' => $request->input('content')
            ]);
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }

    /**
     * 删除数据
     * 
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function del($id)
    {
        try {
            $this->model::destroy($id);
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }

    public function show($id)
    {
        $item = $this->model::where('id', intval($id))->first();
        return view(self::ROUTE . 'part_time_show', compact('item'));
    }
}
