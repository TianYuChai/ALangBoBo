<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/4/8
 * Time: 21:47
 */
namespace App\Http\Models\admin\goods;
use Illuminate\Database\Eloquent\Model;

class BannerModel extends Model
{
    /*首页横幅表*/
    protected $table = 'banner';
    protected $guarded = ['id'];

    private static $_STATUS = [
        0 => '待上架',
        1 => '上架中',
        2 => '已下架'
    ];

    //状态展示
    public function getStatusNameAttribute()
    {
        return array_get(self::$_STATUS, $this->status, '未知');
    }

    //搜索日期
    public function scopeSearchTime($query, $search)
    {
        if(!empty($search)) {
            $section_time = explode(' - ', $search);
            return $query->whereBetween('created_at', $section_time);
        }
    }
}
