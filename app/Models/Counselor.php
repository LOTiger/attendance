<?php

namespace App\Models;

use App\Traits\CounselorTrait;

use Illuminate\Database\Eloquent\Model;

class Counselor extends Model
{
    use CounselorTrait;
    protected $fillable = ['user_id','depar_id'];
}
