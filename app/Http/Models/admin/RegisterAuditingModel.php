<?php

namespace App\Http\Models\admin;

use Illuminate\Database\Eloquent\Model;

class RegisterAuditingModel extends Model
{
    /*会员审核驳回记录表*/
    protected $table = 'registerauditing';
    protected $guarded = ['id'];
}
