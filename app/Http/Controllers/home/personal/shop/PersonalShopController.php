<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/9
 * Time: 16:39
 */
namespace App\Http\Controllers\home\personal\shop;

use App\Http\Controllers\home\BaseController;
use App\Http\Models\currency\MerchantModel;

class PersonalShopController extends BaseController
{
    const ROUTE = HOME_PERSONAL_SHOP; //视图路径
    protected $merchatModel; //个人商户信息

    public function __construct(MerchantModel $merchantModel)
    {
        return $this->merchatModel = $merchantModel;
    }

    public function index()
    {
        return view(self::ROUTE . 'index');
    }
}
