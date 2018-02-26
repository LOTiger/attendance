<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Teacher;
use App\Services\RsaService;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


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
                'account' => $user->account,
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

    public function leaderBoard()
    {
        try
        {
            $this->validate($this->request,[
                'who'=>['required',Rule::in(['student','teacher'])]
            ]);

            return response()->json([
                'status' => 200,
                'data' => $this->getLeaderData($this->request->get('who'))
            ]);

        }
        catch (Exception $exception)
        {
            return response()->json([
                'status' => 404,
                'message' => '系统异常或参数校验失败']);
        }
    }

    protected function getLeaderData($who)
    {
        $data = ['fronters'=>'','backers' => ''];
        if ($who == 'student')
        {
            $data['fronters'] = $this->studentLeaderDataDesc('desc');
            $data['backers'] = $this->studentLeaderDataDesc('asc');
        }
        else
        {
            $data['fronters'] = $this->teacherLeaderDataDesc('desc');
            $data['backers'] = $this->teacherLeaderDataDesc('asc');
        }

        return $data;
    }

    protected function studentLeaderDataDesc($a='desc')
    {
        $students = DB::table('students')
            ->where('att_num','!=',0)
            ->select(DB::raw('id,sign_num/att_num as sign_rate,sign_num,att_num,leave_num,user_id,class_id'))
            ->orderBy('sign_rate',$a)
            ->limit(20)
            ->get();
        $return = array();
        foreach ($students as $key=>$student)
        {
            $className = Classes::getClassName($student->class_id);
            $user = User::query()->find($student->user_id);
            $return[$key]['id']=$user->id;
            $return[$key]['name']=$user->name;
            $return[$key]['account']=$user->account;
            $return[$key]['email']=$user->email;
            $return[$key]['headshot']=$user->headshot;
            $return[$key]['motto']=$user->motto;
            $return[$key]['info']=[
                'att_num' => $student->att_num,
                'sign_num' => $student->sign_num,
                'leave_num' => $student->leave_num,
                'class_name' => $className
            ];
        }

        return $return;
    }

    protected function teacherLeaderDataDesc($a='desc')
    {
        $return = array();
        $teachers = Teacher::all();
        foreach ($teachers as $key => $teacher)
        {
            $speciality = $teacher->speciality;
            $department = $speciality->department;
            $user = $teacher->user;
            $return[$key]['id'] = $user->id;
            $return[$key]['name'] = $user->name;
            $return[$key]['account']=$user->account;
            $return[$key]['email'] = $user->email;
            $return[$key]['headshot'] = $user->headshot;
            $return[$key]['motto'] = $user->motto;
            $return[$key]['info'] =[
                'att_rate' => $teacher->getRate(),
                'att_num' => $teacher->user->attendances->count(),
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
        }
        $return = $a =='desc'?collect($return)->sortByDesc('info.att_rate'):collect($return)->sortBy('info.att_rate');
        $i=0;
        $r=array();
        foreach ($return as $re)
        {
            $r[$i] = $re;
            $i++;
        }
        return $r;

    }

}
