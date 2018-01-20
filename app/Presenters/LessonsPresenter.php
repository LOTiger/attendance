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
use App\User;
use Bican\Roles\Models\Permission;
use Bican\Roles\Models\Role;
use Maatwebsite\Excel\Facades\Excel;

class LessonsPresenter extends Presenter
{

    public function dataReader($path)
    {
        $excel_data = $this->getLessons($path);
        $data = '';
        foreach ($excel_data as $key => $lesson)
        {
            $data .= '<tr>'
                .'<td>'.($key*2+1).'～'.($key*2+2).'</td>';
            foreach ($lesson as $l)
            {

                if (!empty($l[0]))
                {
                    $data .= '<td>'.$l[0]
                        .'◇'.$l[1][0].'到'.$l[1][1].'('.$l[1][2].')'
                        .'◇'.'第'.($l[1][3]?(($key*2+1).'～'.($key*2+2)):($key*2+1)).'节'
                        .'◇'.$l[2];
                    $t = Teacher::getNameByTeacherWorkNum($l[3]);
                    $data .='◇'.($t?$t:暂无).'</td>';
                }
                else
                {
                    $data .= '<td></td>';
                }

            }
            $data .= '</tr>';
        }


        return $data;
    }

    public function aaa()
    {
        return 111;
    }

}