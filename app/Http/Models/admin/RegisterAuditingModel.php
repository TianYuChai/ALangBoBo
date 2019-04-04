<?php

namespace App\Http\Models\admin;

use App\Http\Models\currency\UserModel;
use Illuminate\Database\Eloquent\Model;

class RegisterAuditingModel extends Model
{
    /*会员审核驳回记录表*/
    protected $table = 'registerauditing';
    protected $guarded = ['id'];

    /**
     * 管理会员
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(UserModel::class, 'id', 'uid');
    }

    public function scopeSearchUser($query, $search)
    {
        if(!empty($search)) {
            $user_ids = UserModel::where('account', 'like', "%{$search}%")->get(['id'])->pluck('id');
            return $query->whereIn('id', $user_ids);
        }
    }
}
