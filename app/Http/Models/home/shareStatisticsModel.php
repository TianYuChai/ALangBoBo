<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/24
 * Time: 11:30
 */
namespace App\Http\Models\home;

use Illuminate\Database\Eloquent\Model;

class shareStatisticsModel extends Model
{
    protected $table = 'share_statistics';
    protected $guarded = ['id'];

    public function share()
    {
        return $this->hasOne(shareModel::class, 'id', 'share_id');
    }
}
