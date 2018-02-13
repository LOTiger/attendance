<?php
/**
 * Created by PhpStorm.
 * User: GeChan
 * Date: 2018/1/26
 * Time: 11:37
 */



namespace App\Traits;

use App\User;
use App\Models\Department;
use App\Models\Counselor;
use App\Models\Classes;

trait CounselorTrait
{
    public function department()
    {
        return $this->belongTo('App\Models\Department','depar_id');
    }

    public function user()
    {
        return $this->belongTo('App\User','user_id');
    }

    public function classes()
    {
        return $this->hasMany('App\Models\Classes','counselor_id');
    }






}