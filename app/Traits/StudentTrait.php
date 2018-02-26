<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-13
 * Time: 下午3:06
 */

namespace App\Traits;


use App\Models\Speciality;
use Illuminate\Support\Facades\DB;

trait StudentTrait
{
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function classes()
    {
        return $this->belongsTo('App\Models\Classes','class_id');
    }

    public function className()
    {
        $class = $this->classes;
        $spe = $class->speciality;
        $name = $class->grade.$spe->spe_name.$class->class_num.'班';
        return $name;
    }

    public function name()
    {
       return $this->user->name;
    }

    public function stuNum()
    {
        return $this->user->account;
    }

}