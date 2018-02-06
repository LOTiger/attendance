<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-4
 * Time: 下午10:32
 */

namespace App\Presenters;


use App\Exceptions\PermissionDeniedException;
use App\Models\Department;
use Bican\Roles\Models\Permission;
use Bican\Roles\Models\Role;

class DepartmentsPresenter extends Presenter
{

    public function getDepartmentsList()
    {
        $data = '';
        $allDepartments = Department::all();

        foreach ($allDepartments as $department)
        {
            $data .=
                '<tr onclick="rediredToDepartment('.$department->id.')" id = "depart'.$department->id.'">'
                .'<td>'
                .' <span class="glyphicon glyphicon-tower col-sm-1"></span>'
                .'<div class="col-sm-8">'.$department->depar_name.'</div>'
                .' </td>'
                .'</tr>';
        }


    }

    public function getOneDepartment($id)
    {
        return Department::query()->find($id);
    }



}