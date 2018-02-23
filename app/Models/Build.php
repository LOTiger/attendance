<?php

namespace App\Models;

use App\Traits\BuildTrait;
use Illuminate\Database\Eloquent\Model;

class Build extends Model
{
    use BuildTrait;
    protected $fillable = ['build_name'];
    protected $hidden = [
        'created_at','updated_at'
    ];
}
