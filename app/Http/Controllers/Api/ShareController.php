<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Services\RsaService;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ShareController extends Controller
{
    public $request,$crypt;
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->crypt = new RsaService();
        $this->crypt->select('rsa_api');
    }

    /**
     * 获取用户身份信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoles()
    {
        try
        {
            return response()->json([
                'status' => 200,
                'data' => Auth::guard('api')->user()->roles
            ]);
        }
        catch (Exception $exception)
        {
            return response()->json([
                'status' => 404,
                'message' => '未知错误']);
        }
    }

    /**
     * 获取用户信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsers()
    {
        try
        {
            $user = Auth::guard('api')->user();
            $roles = $user->roles->first()->slug;
            switch ($roles)
            {
                case 'teacher':
                    $info = $this->getTeacherInfo($user->teacher);
                    break;
                case 'student':
                    $info = $this->getStudentInfo($user->student);
                    break;
            }
            $data = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'headshot' => $user->headshot,
                'info' => isset($info)?$info:[]
            ];
            $re = [
                'status' => 200,
                'data' => $data
            ];
            return response()->json($re);
        }
        catch (Exception $exception)
        {
            return response()->json([
                'status' => 404,
                'message' => '产生异常']);
        }
    }

    protected function getTeacherInfo(Teacher $teacher)
    {
        $speciality = $teacher->speciality;
        $department = $speciality->department;
        $info =[
            'teacher_id' => $teacher->id,
            'spe_id' => $speciality->id,
            'speciality' => [
                'id' => $speciality->id,
                'name' => $speciality->spe_name,
                'desc' => $speciality->desc,
                'dep_id' => $speciality->depar_id,
                'department' => [
                    'id' => $department->id,
                    'name' => $department->depar_name,
                    'desc' =>$department->desc
                ]
            ]
        ];
        return $info;
    }

    protected function getStudentInfo(Student $student)
    {
        $class = $student->classes;
        $speciality = $class->speciality;
        $department = $speciality->department;
        $info = [
            'att_num' => $student->att_num,
            'sign_num' => $student->sign_num,
            'leave_num' =>$student->leave_num,
            'class' => [
                'id' => $class->id,
                'stu_num' => $class->stu_num,
                'grade' => $class->grade,
                'class_num' => $class->class_num,
                'spe_id'=>$speciality->id,
                'speciality'=>[
                    'id'=>$speciality->id,
                    'name'=>$speciality->spe_name,
                    'desc'=>$speciality->desc,
                    'dep_id' => $speciality->depar_id,
                    'department' => [
                        'id' => $department->id,
                        'name' => $department->depar_name,
                        'desc' =>$department->desc
                    ]
                ]
            ]
        ];
        return $info;
    }

    /**
     * 用户信息修改
     * @return \Illuminate\Http\JsonResponse
     */
    public function patchUsers()
    {
        try
        {
            $this->validate($this->request,[
                'id'=>'required|integer',
                'name' => 'string'
            ]);
            $user = User::query()->find($this->request->get('id'));
            if (!empty($user))
            {
                $user->name = $this->request->get('name');
                $user->headshot = $this->request->get('headshot');
                $user->save();
                return response()->json([
                    'status' => 200,
                ]);
            }
            else
            {
                return response()->json([
                    'status' => 404,
                    'message' => '找不到该用户']);
            }
        }
        catch (Exception $exception)
        {
            return response()->json([
                'status' => 404,
                'message' => '数据不规范或系统异常']);
        }
    }

    public function getSettings()
    {
        return response()->json([
            'status'=>200,
            'data' =>config('settings')
        ]);
    }

    public function patchPassword()
    {
        try
        {
            $this->validate($this->request,[
                'id'=>'required|integer',
                'origin_password' => 'required',
                'new_password' => 'required'
            ]);
            if (!empty($this->user()))
            {
                return $this->checkPasswordAndUpdate();
            }
            else
            {
                return response()->json([
                    'status' => 404,
                    'message' => '找不到该用户']);
            }
        }
        catch (Exception $exception)
        {
            return response()->json([
                'status' => 404,
                'message' => '数据不规范或系统异常']);
        }
    }

    protected function user()
    {
        return User::query()->find($this->request->get('id'));
    }

    protected function checkPasswordAndUpdate()
    {
        $oldpassword = $this->crypt->decryptPrivate($this->request->get('origin_password'));
        $newpassword = $this->crypt->decryptPrivate($this->request->get('new_password'));
        $user = $this->user();
        if(\Hash::check($oldpassword,$user->password))
        {
            $user->password = bcrypt($newpassword);
            $user->save();
            return response()->json([
                'status' => 200,
            ]);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => '密码校验不通过']);
        }
    }

}
