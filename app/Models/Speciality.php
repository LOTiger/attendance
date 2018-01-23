<?php

namespace App\Models;

use App\Traits\SpecialityTrait;
use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    use SpecialityTrait;
    protected $fillable = [
        'id','spe_name', 'desc','depar_id'
    ];

    protected $hidden = [
        'created_at','updated_at'
    ];
}
