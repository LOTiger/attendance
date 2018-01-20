<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-13
 * Time: 下午3:06
 */

namespace App\Traits;


use App\Models\Department;

trait DepartmentTrait
{
    public function speciality()
    {
        return $this->hasMany('App\Models\Speciality','depar_id');
    }

    public static function getDeparId($depar_name)
    {
        $de = Department::query()->select('id')->where('depar_name',$depar_name);
        return  $de?$de[0]->id:false;
    }

}