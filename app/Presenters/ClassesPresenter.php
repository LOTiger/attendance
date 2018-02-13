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
use Bican\Roles\Models\Permission;
use Bican\Roles\Models\Role;
use Maatwebsite\Excel\Facades\Excel;

class ClassesPresenter extends Presenter
{

    public function getAllClasses()
    {
        $data = '';
        foreach (Classes::all() as $class)
        {
            $data .= '<tr>'
                .'<td>'.$class->grade.'</td>'
                .'<td>'.$class->speciality->spe_name.'</td>'
                .'<td>'.$class->class_num.'</td>'
                .'<td>'.$class->desc.'</td>'
                .'<td>'.$class->speciality->department->depar_name.'</td>'
                .'<td>'.$class->created_at.'</td>'
                .'<td>'.$class->updated_at.'</td>'
                .'<td>
                    <button type="button" class="btn btn-danger" onclick="deleteClass('.$class->id.')">删除</button>
                  </td>'
                .'</tr>';

        }
        return $data;
    }

    public function getDepartmentsRadio($id = null)
    {
        $data = '';
        if ($id == null)
        {
            foreach (Department::all() as $department)
            {
                $data .= '<label>'
                    .'<input type="radio" name="department" class="minimal" value="'
                    .$department->id.'"'
                    .' >'
                    .$department->depar_name
                    .'</label>';
            }
        }
        else
        {
            $speciality = Speciality::query()->find($id);
            foreach (Department::all() as $department)
            {
                $data .= '<label>'
                    .'<input type="radio" name="department" class="minimal" value="'
                    .$department->id.'"';
                if ($speciality->department->id == $department->id)
                {
                    $data .= 'checked="checked"';
                }
                $data .=' >'
                    .$department->depar_name
                    .'</label>';
            }
        }
        return $data;
    }

    public function getOneSpeciality($id)
    {
        return Speciality::query()->find($id);
    }

    public function dataReader($path)
    {
        $excel_data = Excel::load($path)->ignoreEmpty()->get()->toArray();
        $data = '';
        foreach ($excel_data as $class)
        {
            $data .= '<tr>'
                .'<td>'.(int)$class[0].'</td>'
                .'<td>'.$class[1].'</td>'
                .'<td>'.(int)$class[2].'</td>'
                .'<td>'.$class[3].'</td>'
                .'</tr>';
        }
        return $data;
    }


}