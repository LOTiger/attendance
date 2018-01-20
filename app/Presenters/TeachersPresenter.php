<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-4
 * Time: 下午10:32
 */

namespace App\Presenters;


use App\Exceptions\PermissionDeniedException;
use App\Models\Classes;
use App\Models\Department;
use App\Models\Speciality;
use App\Models\Student;
use App\Models\Teacher;
use Bican\Roles\Models\Permission;
use Bican\Roles\Models\Role;
use Maatwebsite\Excel\Facades\Excel;

class TeachersPresenter extends Presenter
{

    public function dataReader($path)
    {
        $excel_data = Excel::load($path)->ignoreEmpty()->get()->toArray();
        $data = '';
        foreach ($excel_data as $teacher)
        {
            $data .= '<tr>'
                .'<td>'.$teacher["工号"].'</td>'
                .'<td>'.$teacher["姓名"].'</td>'
                .'</tr>';
        }
        return $data;
    }

    public function getSpeName($speId)
    {
        $spe = Speciality::query()->find($speId);
        return $spe->spe_name.'教研室';
    }

    public function getAllTeachers()
    {
        $data = '';
        foreach (Teacher::all() as $teacher)
        {
            $data .='<tr>'
                .'<td>'.$teacher->roomName().'</td>'
                .'<td>'.$teacher->name().'</td>'
                .'<td>'.$teacher->workNum().'</td>'
                .'</tr>';
        }
        return $data;
    }

}