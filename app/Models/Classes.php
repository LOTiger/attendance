<?php

namespace App\Models;

use App\Traits\ClassTrait;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use ClassTrait;
    protected $table = 'classes';
    protected $fillable = [
        'class_num', 'desc','spe_id','grade'
    ];
}
