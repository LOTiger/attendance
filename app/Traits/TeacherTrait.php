<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-13
 * Time: 下午3:06
 */

namespace App\Traits;


use App\User;

trait TeacherTrait
{
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function speciality()
    {
        return $this->belongsTo('App\Models\Speciality','spe_id');
    }

    public function roomName()
    {
        $speciality = $this->speciality;
        $name = $speciality->spe_name.'教研室';
        return $name;
    }

    public function name()
    {
       return $this->user->name;
    }

    public function workNum()
    {
        return $this->user->email;
    }

    public static function getNameByTeacherWorkNum($num)
    {
        $teacher = User::query()->where('email',$num)->get();
        return $teacher->count()>0?$teacher[0]->name:false;
    }

    public static function getTeacherIdByWorkNum($num)
    {
        $user = User::query()->where('email',$num)->get();
        if ($user->count()>0)
        {
            if ($user[0]->iss('teacher'))
                return $user[0]->teacher->id;
        }
        return null;
    }

    public function lessons()
    {
        return $this->hasMany('App\Models\Lesson','teacher_id');
    }

    public function getStatusInLessons()
    {
        return $this->lessons->reject(function ($value, $key) {
            return $value->status == 0;
        });
    }

}