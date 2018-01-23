<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-13
 * Time: 下午3:47
 */

namespace App\Traits;


use App\Models\Student;
use App\Models\Teacher;
use App\User;

trait UserTrait
{

    public function getMaxLevel()
    {
        return $this->roles()->orderBy('level','desc')->first()->level;
    }

    public function getLowLevelUsers()
    {
        $data = null;
        $users = User::all();
        foreach ($users as $user)
        {
            if ($user->getMaxLevel() < $this->getMaxLevel())
                $data[] =$user;
        }
        return $data;
    }

    public function attachRolesArray(Array $roles)
    {
        foreach ($roles as $role)
        {
            $this->attachRole($role);
        }
        return true;
    }

    public static function checkUserExit($email)
    {
        return User::query()->where('email', $email)->get()->count()?true:false;
    }

    public function attachStudent($classId)
    {
        return Student::query()->create([
            'user_id' => $this->id,
            'class_id' => $classId
        ]);
    }

    public function attachTeacher($speId)
    {
        return Teacher::query()->create([
            'user_id' => $this->id,
            'spe_id' => $speId
        ]);
    }

    public function teacher()
    {
        return $this->hasOne('App\Models\Teacher');
    }
}