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
use App\Models\Speciality;
use Bican\Roles\Models\Permission;
use Bican\Roles\Models\Role;

class SpecialitiesPresenter extends Presenter
{

    public function getAllSpecialities()
    {
        $data = '';
        foreach (Speciality::all() as $speciality)
        {
            $data .= '<tr>'
                .'<td>'.$speciality->spe_name.'</td>'
                .'<td>'.$speciality->desc.'</td>'
                .'<td>'.$speciality->department->depar_name.'</td>'
                .'<td>'.$speciality->created_at.'</td>'
                .'<td>'.$speciality->updated_at.'</td>'
                .'<td>
                    <button type="button" class="btn btn-danger" onclick="deleteSpeciality('.$speciality->id.')">删除</button>
                    <a href="'.route('show.edit.speciality.form')
                .'?id='.$speciality->id.'"><button type="button" class="btn btn-warning"">修改</button></a>
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



}