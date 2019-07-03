<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/13
 * Time: 11:14
 */
namespace App\Http\Controllers\home\personal;

use App\Http\Controllers\home\BaseController;
use App\Http\Models\home\partTimeSendModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Exception;

class PersonalSendTimeController extends BaseController
{
    const ROUTE = HOME_PERSONAL;

    public function __construct(partTimeSendModel $model)
    {
        $this->middleware(function ($request, $next) use ($model){
            if(Auth::guard('web')->check()) {
                $this->user = Auth::guard('web')->user();
            }
            $this->model = $model;
            return $next($request);
        });
    }

    public function index()
    {
        $title = trim(Input::get('title', ''));
        $items = $this->model::where('uid', $this->user->id)
                            ->SearchTitle($title)
                            ->orderBy('id', 'desc')->paginate(parent::$page_limit);
        dd($items->get());
        return view(self::ROUTE . 'time_send_record', compact('items'));
    }

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
