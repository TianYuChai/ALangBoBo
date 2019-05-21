<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/20
 * Time: 17:23
 */
namespace App\Http\Controllers\home\Personal\shop;

use App\Http\Controllers\home\BaseController;
use App\Http\Models\currency\MerchantBannerModel;
use App\Http\Models\currency\MerchantModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use FileUpload;

class PersonalBannerController extends BaseController
{
    const ROUTE = HOME_PERSONAL_SHOP; //视图路径
    protected $merchatModel; //个人商户信息
    protected $user;
    protected $model;

    public function __construct(MerchantModel $merchantModel, MerchantBannerModel $model)
    {
        $this->middleware(function ($request, $next) use ($merchantModel, $model){
            $this->merchatModel = $merchantModel;
            $this->model = $model;
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    public function index()
    {
        $items = $this->model::where([
            'uid' => $this->user->id,
            'status' => 0
        ])->orderBy('sort', 'desc')->get();
        return view(self::ROUTE . 'banner', compact('items'));
    }

    /**
     * 添加数据
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $url = trim($request->url);
            $sort = trim($request->sort);
            $img = trim($request->img);
            if(!$url) {
                throw new Exception('请输入域名地址');
            }
            if(!$sort) {
                throw new Exception('请输入排序值');
            }
            if(!regularHaveSinoram($sort)) {
                throw new Exception('排序值, 不可用');
            }
            if(!FileUpload::exists('image', $img)) {
                throw new Exception('请上传图片');
            }
            if($this->model::where('uid', $this->user->id)->count() > 3) {
                throw new Exception('超出图片限制, 当前已有三张图片');
            }
            $this->model::create([
                'uid' => $this->user->id,
                'url' => $url,
                'image' => $img,
                'sort' => intval($sort)
            ]);
            return $this->ajaxReturn([
                'status' => 200,
                'info' => '添加成功'
            ], 200);
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }

    /**
     * 展示数据
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        try {
            $item = $this->model::where([
                'id' => intval($id),
                'uid' => $this->user->id,
                'status' => 0
            ])->first();
            return $this->ajaxReturn([
                'status' => 200,
                'data' => [
                    'action' => route('personal.banner.update', ['id' => $item->id]),
                    'url' => $item->url,
                    'image' => $item->image,
                    'image_url' => FileUpload::url('image', $item->image),
                    'sort' => $item->sort
                ]
            ], 200);
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => 510,
                'info' => $e->getMessage()
            ], 510);
        }
    }

    /**
     * 更新内容
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        try {
            $url = trim($request->edit_url);
            $sort = trim($request->edit_sort);
            $img = trim($request->img);
            if(!$url) {
                throw new Exception('请输入域名地址');
            }
            if(!$sort) {
                throw new Exception('请输入排序值');
            }
            if(!regularHaveSinoram($sort)) {
                throw new Exception('排序值, 不可用');
            }
            if(!FileUpload::exists('image', $img)) {
                throw new Exception('请上传图片');
            }
            $this->model::where([
                'id' => intval($id),
                'uid' => $this->user->id,
            ])->update([
                'uid' => $this->user->id,
                'url' => $url,
                'image' => $img,
                'sort' => intval($sort)
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
}
