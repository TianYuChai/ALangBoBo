<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/4/2
 * Time: 17:13
 */
namespace App\Http\Services\admin;

class BaseService {
    public function __construct()
    {
        $this->User = auth()->guard('backstage')->user();
    }
}
