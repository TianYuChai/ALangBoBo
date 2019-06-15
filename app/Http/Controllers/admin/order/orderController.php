<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/11
 * Time: 14:40
 */
namespace App\Http\Controllers\admin\order;

use App\Http\Controllers\admin\BaseController;
use App\Http\Models\home\shoppOrderModel;
use Illuminate\Support\Facades\Input;

class orderController extends BaseController
{
    const ROUTE = ADMING_ORDER; //视图路径

    public function index()
    {
        $order_id = trim(Input::get('order_id', ''));
        $status = trim(Input::get('status', ''));
        $items = shoppOrderModel::SearchOrderId($order_id)->SearchStatus($status)->orderBy('id', 'desc')->paginate(parent::$page_limit);
        $data = [
            'items' => $items,
            'status' => shoppOrderModel::$_STATUS
        ];
        return view(self::ROUTE . 'index', compact('data'));
    }

    public function show($id)
    {
        $item = shoppOrderModel::find($id);
        return view(self::ROUTE . 'show', compact('item'));
    }
}
