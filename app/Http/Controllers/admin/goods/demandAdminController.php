<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/6/15
 * Time: 19:25
 */
namespace App\Http\Controllers\admin\goods;

use App\Http\Controllers\admin\BaseController;
use App\Http\Models\home\demandModel;
use Illuminate\Support\Facades\Input;

class demandAdminController extends BaseController
{
    const ROUTE = ADMIN_GOODS_CATEGORY. 'demand';

    public function index()
    {
        $account = trim(Input::get('account_name', ''));
        $status = Input::get('status', '');
        $items = demandModel::SearchAccount($account)
                                ->SearchStatus($status)
                                ->orderBy('id', 'desc')
                                ->paginate(parent::$page_limit);
        return view(self::ROUTE . '.index', compact('items'));
    }

    public function show($id)
    {
        $item = demandModel::find($id);
        return view(self::ROUTE . '.show', compact('item'));
    }
}