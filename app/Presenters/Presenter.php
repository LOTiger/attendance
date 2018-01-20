<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-14
 * Time: 下午6:05
 */

namespace App\Presenters;


use App\Models\Classes;
use App\Models\Department;
use App\User;
use Bican\Roles\Models\Permission;
use Bican\Roles\Models\Role;
use Maatwebsite\Excel\Facades\Excel;

class Presenter
{

    /**
     * 根据id获取一个用户
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function getOneUser($id)
    {
        return User::query()->find($id);
    }

    /**
     * 获取所有角色
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllRoles()
    {
        return Role::all();
    }

    /**
     * 获取与user关联的角色
     * @param $id
     * @return mixed
     */
    public function getRoleByUser($id)
    {
        return User::query()->find($id)->roles;
    }

    /**
     * 获取一个操作
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function getOnePermission($id)
    {
        return Permission::query()->find($id);
    }

    /**
     * 获取操作总数
     * @return int
     */
    public function getPermissionsNum()
    {
        return Permission::all()->count();
    }

    /**
     * 获取角色总数
     * @return int
     */
    public function getRolesNum()
    {
        return Role::all()->count();
    }

    public function getClassName($id)
    {
        return Classes::getClassName($id);
    }

    public function getUsersNum()
    {
        return User::all()->count();
    }

    public function getAllDepartments()
    {
        return Department::all();
    }

    public function getDepartmentOptions()
    {
        $data = '';
        foreach ($this->getAllDepartments() as $key => $department)
        {
            $data .= '<option 
                value="'.$department->id.'"'.($key == 0? "selected":'').'>'
                .$department->depar_name.'</option>';
        }
        return $data;
    }

    public function getLessons($path)
    {
        return $this->cutLesson($this->getSeasonLessonArray($path));
    }

    public function cutLesson($data)
    {
        $r = [];
        foreach ($data as $key => $d)
        {
            if ($d)
            {
                foreach ($d as $k=> $l)
                {
                    $r[$key][$k] = $this->cutLessonString($l);
                    if ($l)
                        $r[$key][$k][1] = $this->getWeekBeginAndEnd($r[$key][$k][1]);
                }
            }
            else
            {
                $r[$key] = $d;
            }
        }
        return $r;
    }

    public function cutLessonString($lesson)
    {
        return explode("◇",$lesson);
    }

    public function getWeekBeginAndEnd($week)
    {
        $w = explode("(",$week);
        $r = explode("-",$w[0]);
        if (!is_numeric($r[1]))
        {
            $a = $r[1];
            preg_match('/\d+/',$a,$b);
            $r[1] = $b[0];
            $r[2] = explode((string)$r[1],$a)[1];
        }
        else
            $r[2] = '满';
        if (strstr($w[1],','))
            $r[3] = true;
        else
            $r[3] = false;
        return $r;
    }

    public function getSeasonLessonArray($path)
    {
        $lessonsData = array_slice(Excel::load($path)->ignoreEmpty()->get()->toArray()[0],2,6);
        $data = [];
        foreach ($lessonsData as $key => $lesson)
        {
            $data[$key] = array_slice($lesson, 2,5);
        }
        return $data;
    }

}