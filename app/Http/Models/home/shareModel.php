<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/24
 * Time: 11:29
 */
namespace App\Http\Models\home;

use Illuminate\Database\Eloquent\Model;

class shareModel extends Model
{
    protected $table = 'share';
    protected $guarded = ['id'];

    public function statistics()
    {
        return $this->hasMany(shareStatisticsModel::class, 'share_id', 'share_id');
    }

    /**
     * 搜索
     *
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearchShare($query, $search)
    {
        if(!empty($search)) {
            return $query->where('share_id', $search);
        }
    }
}
