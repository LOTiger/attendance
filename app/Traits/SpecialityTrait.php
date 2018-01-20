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

trait SpecialityTrait
{
    public function department()
    {
        return $this->belongsTo('App\Models\Department','depar_id');
    }

    public static function getSpeId($spe_name)
    {
        $sp = Speciality::query()->where('spe_name',$spe_name)->get();
        return  $sp?$sp[0]->id:false;
    }

    public function classes()
    {
        return $this->hasMany('App\Models\Classes','spe_id');
    }


}