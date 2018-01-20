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

trait BuildTrait
{
    public static function checkBuildExit($name)
    {
        return Build::query()->where('build_name',$name)->get()->count()>0;
    }

    public function room()
    {
        return $this->hasMany('App\Models\Room','build_id');
    }

    public static function getRoomIdByName($s)
    {
        preg_match('/\d+/',$s,$b);
        $roomName = $b[0];
        $buildName = explode($roomName,$s)[0];
        $build = Build::query()->where('build_name',$buildName)->get()[0]->id;
        $room = Room::query()->where(['build_id'=>$build,'room_name'=>$roomName])->get();
        return $room[0]->id;
    }



}