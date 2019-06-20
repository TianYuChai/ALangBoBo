<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/24
 * Time: 9:49
 */
namespace App\Http\Controllers\home\personal\shop;

use App\Http\Controllers\home\BaseController;
use App\Http\Models\home\shareModel;
use App\Http\Models\home\shareStatisticsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Input;

class PersonalGeneralizeController extends BaseController
{
    const ROUTE = HOME_PERSONAL_SHOP;

    public function __construct(shareModel $shareModel, shareStatisticsModel $shareStatisticsModel)
    {
        $this->middleware(function ($request, $next) use ($shareModel, $shareStatisticsModel) {
            $this->user = Auth::guard('web')->user();
            $this->shareModel = $shareModel;
            $this->shareStatisticsModel = $shareStatisticsModel;
            return $next($request);
        });
    }

    public function index()
    {
        $keyword = trim(Input::get('keyword', ''));
        $items = $this->shareModel::where('gid', $this->user->id)->SearchShare($keyword)->paginate(parent::$page_limit);
        return view(self::ROUTE . 'generalize', compact('items'));
    }

    /**
     * 添加分享者
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $name = trim($request->name);
            $item = $this->shareModel::create([
               'name' => $name,
               'gid' => $this->user->id,
               'share_id' => code()
            ]);
            return $this->ajaxReturn([
                'status' => 200,
                'url' => route('merchant.show', ['id' => $this->user->merchant['id']]).'?referess='.$item->share_id
            ], 200);
        } catch (Exception $e) {
            return $this->ajaxReturn([
                'status' => '510',
                'info' => $e->getMessage()
            ], 510);
        }
    }
}
