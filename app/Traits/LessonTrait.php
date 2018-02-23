<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-13
 * Time: 下午3:06
 */

namespace App\Traits;


use App\Models\Classes;
use App\Models\Room;
use App\Models\Speciality;
use App\Models\Counselor;
use Illuminate\Support\Facades\DB;

trait LessonTrait
{

    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher','teacher_id');
    }

    public function classes()
    {
        return $this->belongsTo('App\Models\Classes','class_id');
    }

    public function room()
    {
        return $this->belongsTo('App\Models\Room','room_id');
    }

}