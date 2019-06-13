<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/13
 * Time: 9:23
 */
namespace App\Http\Models\home;

use App\Http\Models\currency\UserModel;
use Illuminate\Database\Eloquent\Model;

class partTimeSendModel extends Model
{
    /*兼职投递记录表*/
    protected $table = 'part_time_send';
    protected $guarded = ['id'];


    public function user()
    {
        return $this->hasOne(UserModel::class, 'id', 'uid');
    }

    public function part()
    {
        return $this->hasOne(partTimeModel::class, 'id', 'pid');
    }

    public function scopeSearchTitle($query, $search)
    {
        if(!empty($search)) {
            $ids = partTimeModel::where('title', 'like', "%$search%")->get()->pluck('id')->toArray();
            return $query->whereIn('pid', $ids);
        }
    }
}
