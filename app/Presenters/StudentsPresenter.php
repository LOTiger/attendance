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
use Bican\Roles\Models\Permission;
use Bican\Roles\Models\Role;
use Maatwebsite\Excel\Facades\Excel;

class StudentsPresenter extends Presenter
{

    public function dataReader($path)
    {
        $excel_data = Excel::load($path)->ignoreEmpty()->get()->toArray();
        $data = '';
        foreach ($excel_data as $student)
        {
            $data .= '<tr>'
                .'<td>'.$student["学号"].'</td>'
                .'<td>'.$student["姓名"].'</td>'
                .'</tr>';
        }
        return $data;
    }

    public function getAllStudents()
    {
        $data = '';
        foreach (Student::all() as $student)
        {
            $data .='<tr>'
                .'<td>'.$student->className().'</td>'
                .'<td>'.$student->name().'</td>'
                .'<td>'.$student->stuNum().'</td>'
                .'</tr>';
        }
        return $data;
    }

}