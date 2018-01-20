<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-13
 * Time: 下午3:06
 */

namespace App\Traits;


use App\Models\Build;
use App\Models\Room;

trait RoomTrait
{
    public function build()
    {
        return $this->belongTo('App\Models\Build','build_id');
    }

    public static function checkRoom($build_id,$room_name)
    {
        return Room::query()->where(['build_id'=>$build_id,'room_name'=>$room_name])->get()->count()>0;
    }



}