<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-13
 * Time: 下午3:06
 */

namespace App\Traits;


use App\Models\Classes;
use App\Models\Speciality;
use Illuminate\Support\Facades\DB;

trait ClassTrait
{

    public function speciality()
    {
        return $this->belongsTo('App\Models\Speciality','spe_id');
    }

    public function lessons()
    {
        return $this->hasMany('App\Models\Lesson','class_id');
    }

    public function changeLessonStatus()
    {
        foreach ($this->lessons as $lesson)
        {
            $lesson->status = 0;
            $lesson->save();
        }
    }

    public static function checkClassExit($grade,$spe_id,$class_num)
    {
        return Classes::query()->where(['grade'=>$grade,'spe_id'=>$spe_id,'class_num'=>$class_num])->get()->count()>0?true:false;
    }

    public static function getClassId($grade,$spe_id,$class_num)
    {

        $class = Classes::query()->where(['grade'=>$grade,'spe_id'=>$spe_id,'class_num'=>$class_num])->first();
        return $class?$class->id:false;
    }

    public static function getClassName($id)
    {
        $class = Classes::query()->find($id);
        $spe = $class->speciality;
        $name = $class->grade.$spe->spe_name.$class->class_num."班";
        return $name;
    }


}