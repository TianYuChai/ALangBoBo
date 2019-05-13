<?php

namespace App\Http\Models\home\personal;

use App\Http\Models\currency\UserModel;
use Illuminate\Database\Eloquent\Model;

class CancellModel extends Model
{
    /*地址表*/
    protected $table = 'cancell';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasOne(UserModel::class, 'id', 'uid');
    }

    /**
     * 查询用户
     *
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearchAccount($query, $search)
    {
        if(!empty($search)) {
            $user_ids = UserModel::where('account', 'like', "%$search%")->value('id');
            return $query->where('uid', $user_ids);
        }
    }
}
