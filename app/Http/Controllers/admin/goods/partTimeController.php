<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/6/15
 * Time: 18:40
 */
namespace App\Http\Controllers\admin\goods;

use App\Http\Controllers\admin\BaseController;
use App\Http\Models\home\partTimeModel;
use Illuminate\Support\Facades\Input;

class partTimeController extends BaseController
{
    const ROUTE = ADMIN_GOODS_CATEGORY.'part_time';

    public function index()
    {
        $account = trim(Input::get('account_name', ''));
        $items = partTimeModel::SearchAccout($account)->orderBy('id', 'desc')->paginate(parent::$page_limit);
        return view(self::ROUTE.'.part_time', compact('items'));
    }

    public function show($id)
    {
        $item = partTimeModel::find($id);
        return view(self::ROUTE. '.show', compact('item'));
    }
}