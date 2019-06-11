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
            'p_id' => 19,
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
                'describe' => trim($request->describe),
                'content' => $request->content
            ]);
            return $this->ajaxReturn();
       } catch (Exception $e) {
           return $this->ajaxReturn([
               'status' => 510,
               'info' => $e->getMessage()
           ], 510);
       }
    }

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
}
