<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/5/5
 * Time: 22:36
 */
namespace App\Http\Models\currency;

use Illuminate\Database\Eloquent\Model;

class CapitalModel extends Model
{
    /*资金表*/
    protected $table = 'capital';
    protected $guarded = ['id'];
    /**
     * 交易类别
     *
     * @var array
     */
    public static $_TRADEMODE = [
        "WeChat" => "微信",
        "Alipay" => "支付宝",
        'qpay' => "快捷支付"
    ];

    /**
     * 资金来源
     * @var array
     */
    public static $_CATEGORY = [
        100 => '充值',
        200 => '提现',
        300 => '信用保证金',
        400 => '购买货品',
        500 => '出售货品',
        600 => '入驻费'
    ];

    /**
     * 资金状态
     *
     * @var array
     */
    public static $_STATUS = [
        1001 => '可用', //交易成功
        1002 => '不可用', // 交易失败
        1003 => '冻结',
        1004 => '支付完成'
    ];

    /**
     * 类别展示
     *
     * @return mixed
     */
    public function getTradeModeNameAttribute()
    {
        return array_get(self::$_TRADEMODE, $this->trade_mode, '未知');
    }

    /**
     * 来源展示
     *
     * @return mixed
     */
    public function getCategoryNameAttribute()
    {
        return array_get(self::$_CATEGORY, $this->category, '未知');
    }

    /**
     * 状态展示
     *
     * @return mixed
     */
    public function getStatusNameAttribute()
    {
        return array_get(self::$_STATUS, $this->status, '未知');
    }
}
