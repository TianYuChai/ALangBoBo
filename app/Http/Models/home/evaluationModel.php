<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/6/10
 * Time: 9:58
 */
namespace App\Http\Models\home;

use Illuminate\Database\Eloquent\Model;

class evaluationModel extends Model
{
    /*评价表*/
    protected $table = 'evaluation';
    protected $guarded = ['id'];
}
