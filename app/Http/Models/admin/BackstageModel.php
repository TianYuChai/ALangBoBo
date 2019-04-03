<?php

namespace App\Http\Models\admin;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BackstageModel extends Authenticatable
{
    /*后台-用户表*/
    use Notifiable;

    protected $table = 'backstage';
    protected $guarded = ['id'];

    /**
     * 改写
     * @var string
     */
    protected $rememberTokenName = '';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];
}
