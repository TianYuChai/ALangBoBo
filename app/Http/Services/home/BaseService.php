<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/2
 * Time: 17:13
 */
namespace App\Http\Services\home;

use Illuminate\Support\Facades\Auth;

class BaseService {
    protected $userId = null;
    protected static $page_limit = 30;
    public function __construct()
    {
        if(Auth::guard('web')->check()) {
            $this->user = Auth::guard('web')->user();
            $this->userId = Auth::guard('web')->id();
        }
    }

}
