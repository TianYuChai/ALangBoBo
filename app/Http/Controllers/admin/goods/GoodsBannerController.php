<?php
namespace App\Http\Controllers\admin\goods;

use Exception;
use FileUpload;
use Illuminate\Http\Request;
use App\Http\Models\admin\goods\BannerModel;
use App\Http\Controllers\admin\BaseController;
use App\Http\Requests\admin\goods\BannerRequest;
use App\Http\Services\admin\Goods\bannerService;
use Illuminate\Support\Facades\DB;

class GoodsBannerController extends BaseController
{
    const ROUTE = ADMIN_GOODS_CATEGORY; //视图路径

    /**
     * 搜索
     *
     * @param $query
     * @param $data
     * @return mixed
     */
    public function makeQuery($query, $data)
    {
        return $query->SearchTime($data['section_time']);
    }

    /**
     * 首页
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $section_time = $request->input('section_time', '');
        $query = $this->makeQuery(new BannerModel(), [
            'section_time' => $section_time
        ]);
        $items = $query->orderBy('id', 'desc')->paginate(parent::$page_limit);
        $data = [
            'items' => $items,
            'select_section_time' => $section_time
        ];
        return view(self::ROUTE. 'banner.index', compact('data'));
    }

    /**
     * 横幅添加展示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view(self::ROUTE. 'banner.create');
    }

    /**
     * 横幅添加
     *
     * @param BannerRequest $request
     * @param bannerService $bannerService
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BannerRequest $request, bannerService $bannerService)
    {
        try {
            $filtered_data = $bannerService->dataProcessing($request);
            $bannerService->depositInDb($filtered_data);
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => 510
            ], 510);
        }
    }

    /**
     * 对未下架横幅进行相关操作
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function stateOperation($id)
    {
        try {
            $item = BannerModel::findOrFail($id);
            if($item->status == 2) {
                throw new Exception('横幅已下架, 不可进行相关操作');
            }
            if($item->status == 0 && $item->end_time < getTime('ymd')) {
                throw new Exception('横幅已超出可操作时间, 结束时间已过期');
            }
            $item->status = $item->status == 0 ? 1 : ($item->status == 1 ? 2 : 0);
            $item->save();
            return $this->ajaxReturn();
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'info' => $e->getMessage(),
                'status' => 510
            ], 510);
        }
    }

    /**
     * 删除横幅
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function del($id)
    {
        try {
            $item = BannerModel::findOrFail($id);
            FileUpload::del('image', $item->image_url);
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
