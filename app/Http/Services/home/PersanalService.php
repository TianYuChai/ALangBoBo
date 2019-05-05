<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/5/5
 * Time: 23:13
 */
namespace App\Http\Services\home;

use App\Http\Models\currency\CapitalModel;
use Illuminate\Support\Facades\Auth;

class PersanalService extends BaseService
{
    protected $userId = null;
    protected $capital;
    public function __construct(CapitalModel $capital)
    {
        $this->userId =  Auth::guard('web')->user()->id;
        $this->capital = $capital;
    }

    /**
     * 获取用户冻结金额
     *
     * @return mixed
     */
    public function frozenCapital()
    {
        return $this->capital::where([
            'category' => 300,
            'status' => 1001
        ])->sum('money');
    }
}