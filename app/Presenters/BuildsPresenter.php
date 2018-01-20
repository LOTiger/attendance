<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-6
 * Time: 下午11:07
 */

namespace App\Presenters;


use App\Models\Build;

class BuildsPresenter extends Presenter
{
    public function getBuildsList()
    {
        $data = '';

        foreach (Build::all() as $build)
        {
            $data .=
                '<tr onclick="rediredTo('.$build->id.')" id = "build'.$build->id.'">'
                .'<td>'
                .' <span class="glyphicon glyphicon-home col-sm-1"></span>'
                .'<div class="col-lg-8">'.$build->build_name.'</div>'
                .' </td>'
                .'</tr>';
        }

        return $data;
    }

    public function getRoomsList($build_id)
    {
        $data = '';
        if ($build_id)
        {
            $build = Build::query()->find($build_id);
            $rooms = $build->room;
            foreach ($rooms as $room)
            {
                $data .= '<span class="btn btn-success" style="margin:10px">' .$build->build_name. $room->room_name . '</span>';
            }
        }
        return $data;
    }

    public function editRoomsList($build_id)
    {
        $data = '';
        if ($build_id)
        {
            $build = Build::query()->find($build_id);
            $rooms = $build->room;
            foreach ($rooms as $room)
            {
                $data .= '<tr>'
                .'<td>'.$build->build_name.$room->room_name.'</td>'
                .'<td><button class="btn btn-warning" type="button" onclick="deleteRoom('.$room->id.')">删除</button></td>'
                .'</tr>';
            }
        }
        return $data;
    }



}