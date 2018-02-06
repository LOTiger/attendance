<?php
/**
 * Created by PhpStorm.
 * User: GeChan
 * Date: 2018/1/26
 * Time: 11:34
 */

namespace App\Presenters;

use App\Models\Counselor;
use App\Models\Classes;
use App\Models\Department;
use App\Models\Speciality;
use App\User;
use function GuzzleHttp\Promise\all;


class CounselorsPresenter extends Presenter
{

    public function getDepartmentsList()
    {
        $data = '';
        $allDepartments = Department::all();

        foreach ($allDepartments as $department) {
            $data .=
                '<tr onclick="rediredTo(' . $department->id . ')" id = "depart' . $department->id . '">'
                . '<td>'
                . ' <span class="glyphicon glyphicon-tower col-sm-1"></span>'
                . '<div class="col-sm-8">' . $department->depar_name . '</div>'
                . ' </td>'
                . '</tr>';

        }

        return $data;

    }

    public function getCounselorsList($depar_id)
    {
        $data = '';
        if ($depar_id) {
            $counselors = Counselor::where('depar_id', '=', $depar_id)->get();

            foreach ($counselors as $counselor) {

                $counselor_name = User::find($counselor->user_id)->name;
                $data .= ' <button class="btn btn-success" style="margin:10px" type="button" onclick="showClass(' . $counselor->id . ')">' . $counselor_name . '</button>';


            }
        }
        return $data;

    }

    public function editCounselorsList($depar_id)
    {
        $data = '';
        if ($depar_id) {
            $counselors = Counselor::where('depar_id', '=', $depar_id)->get();

            foreach ($counselors as $counselor) {
                $counselor_name = User::find($counselor->user_id)->name;

                $data .= '<tr>'
                    . '<td>' . $counselor_name . '</td>'
                    . '<td>
                        <button class="btn btn-warning" type="button" onclick="deleteCounselor(' . $counselor->user_id . ')">删除</button>
                        <button class="btn btn-warning" type="button" onclick="updateCounselor(' . $counselor->user_id . ') ">修改</button>

                       </td>'
                    . '</tr>';
            }
        }
        return $data;
    }


    public function getOneCounselor($id)
    {

        return User::query()->find($id);

    }

    public function getCounselorname($id)
    {


        $user_id = Counselor::where('id', '=', $id)->first();
        $counselor_name = User::where('id', '=', $user_id->user_id)->first();
        return $counselor_name->name;


    }

    public function getClassList($id)
    {
        $data = '';
        if ($id) {
            $classes = Classes::where('counselor_id', '=', $id)->get();


            foreach ($classes as $class) {
                $data .= '<tr>'
                    . '<td>' . $class->grade . '</td>'
                    . '<td>' . $class->speciality->spe_name . '</td>'
                    . '<td>' . $class->class_num . '</td>'
                    . '<td>' . $class->desc . '</td>'
                    . '<td>' . $class->speciality->department->depar_name . '</td>'
                    . '<td>' . $class->created_at . '</td>'
                    . '<td>' . $class->updated_at . '</td>'
                    . '<td>
                    <button type="button" class="btn btn-danger" onclick="deleteClass(' . $class->id . ')">删除</button>
                    <button type="button" class="btn  btn-warning" onclick="updateClass(' . $class->id . ')">修改</button>
                      </td>'
                    . '</tr>';

            }

            //dd($data);
            return $data;
        }


    }


    public function getOnedeparname($id)
    {
        $depar_id = Counselor::where('user_id', '=', $id)->first();

        $depar_name = Department::where('id', '=', $depar_id->depar_id)->first();
        return $depar_name->depar_name;

    }


    public function getAllclasses()
    {
        return Classes::all();
    }

    public function getAllclassesOptions($id = null)
    {
        $data = '';
        if ($id == null) {
            foreach ($this->getAllclasses() as $key => $class) {
                $data .= '<label>'
                    . '<input type="checkbox" name="checkbox1[]" class="minimal" value="'
                    . $class->id . '" >'
                    . $class->speciality->department->depar_name
                    . $class->grade
                    . $class->speciality->spe_name
                    . $class->class_num
                    . '</label>';
            }
        } else {
            foreach ($this->getAllclasses() as $key => $class) {
                $classes = Classes::query()->find($id);

                $data .= '<label>'
                    . '<input type="checkbox" name="checkbox1[]" class="minimal" value="'
                    . $class->id . '"';
                if ($classes->id == $class->id) {
                    $data .= 'checked="checked"';
                }
                $data .= '<label>'
                    . '<input type="checkbox" name="checkbox1[]" class="minimal" value="'
                    . $class->id . '" >'
                    . $class->speciality->department->depar_name
                    . $class->grade
                    . $class->speciality->spe_name
                    . $class->class_num
                    . '</label>';
            }
        }
        return $data;
    }


    public function getOneclassesOptions($id)
    {
        $data = '';
        if ($id) {
            $classes = Classes::where('id', '=', $id)->get();

            foreach ($classes as $class) {
                $data .= '<label>' . $class->grade . $class->speciality->spe_name .
                    $class->class_num . $class->speciality->department->depar_name . '</label>';
            }
            return $data;
        }

    }
}


