<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\SignIn;
use App\Models\Student;
use App\Models\Teacher;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TeacherController extends Controller
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * 获取老师的个人信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        try
        {
            return response()->json([
                'status' => 200,
                'data' => User::query()
                    ->where('id',Auth::guard('api')->id())
                    ->with('teacher.speciality.department')
                    ->get()[0]
        ]);
        }
        catch (Exception $exception)
        {
            return response()->json([
                'status' => 404,
                'message' => '未知错误'
            ]);
        }
    }

    /**
     * 获取老师的课程信息
     * @param $teacher_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function lessons($teacher_id)
    {
        try
        {
            $teacher = Teacher::query()->find($teacher_id);
            if (!empty($teacher))
            {
                $lessons = $teacher->getStatusInLessons();
                foreach ($lessons as $key=>$lesson)
                {
                    $lessons[$key]->room->build = $lesson->room->build;
                    $lessons[$key]->classes->speciality->department = $lesson->classes->speciality->department;
                    $lessons[$key]->teacher->user = $lesson->teacher->user;
                }
                $lessons = array_flatten((Array)$lessons);
                return response()->json([
                    'status' => 200,
                    'data' => $lessons
                ]);
            }
            else
            {
                return response()->json([
                    'status'=> 404,
                    'message' => '老师不存在'
                ]);
            }
        }
        catch (Exception $exception)
        {
            return response()->json([
                'status' => 404,
                'message' => '未知错误'
            ]);
        }
    }

    public function attendances()
    {
        try{
            $this->validate($this->request,[
                'att_token' => 'required|string',
                'should' => 'required|integer',
                'clbum_id' => 'required|integer',
                'creator_id' => 'required|integer'
            ]);
        }
        catch (Exception $exception)
        {
            return response()->json([
                'status' => 404,
                'message' => '数据不符合规范'
            ]);
        }

        $attendance = Attendance::query()->create([
            'att_token' => $this->request->get('att_token'),
            'should' => $this->request->get('should'),
            'class_id' => $this->request->get('clbum_id'),
            'creator_id' => $this->request->get('creator_id')
        ]);
        return response()->json([
            'status' => 200,
            'data' => $attendance
        ]);
    }

    public function deleteAttendance($att_id)
    {
        if (is_numeric($att_id))
        {
            try
            {
                Attendance::query()->find($att_id)->delete();
                return response()->json([
                    'status' => 200,
                ]);
            }
            catch (Exception $exception)
            {
                return response()->json([
                    'status' => 404,
                ]);
            }
        }
        else
        {
            return response()->json([
                'status' => 404,
            ]);
        }
    }

    public function signIn()
    {
        try
        {
            $this->validate($this->request,[
                'att_id' => 'required|integer',
                'clbum_id' => 'required|integer'
            ]);
            if (count($this->request->get('sign_stu_id'))>0)
            {
                foreach ($this->request->get('sign_stu_id') as $stu_id)
                {
                    SignIn::query()->create([
                        'att_id' => $this->request->get('att_id'),
                        'stu_id' => $stu_id
                    ]);
                    Student::query()->where('id',$stu_id)->increment('sign_num');
                }
            }

            if (count($this->request->get('leave_stu_id'))>0)
            {
                foreach ($this->request->get('leave_stu_id') as $stu_id)
                {
                    Student::query()->where('id',$stu_id)->increment('leave_num');
                }
            }

            DB::table('students')->where('class_id',$this->request->get('clbum_id'))->increment('att_num');

            $attendance = Attendance::query()->find($this->request->get('att_id'));
            $attendance->status = 0;
            $attendance->save();

            return response()->json([
                'status' => 200
            ]);

        }
        catch (Exception $exception)
        {
            return response()->json([
                'status' => 404,
                'message' => '数据不符合规范或其他异常'
            ]);
        }
    }

    public function attendancesByToken()
    {
        try{
            $this->validate($this->request,[
                'att_tokens' => 'required|string',
            ]);
        }
        catch (ValidationException $exception)
        {
            return response()->json([
                'status' => 404,
                'message' => '数据不符合规范'
            ]);
        }
        try
        {
            $tokens = json_decode($this->request->get('att_tokens'),true);
            $attendance = Attendance::query()
                ->whereIn('att_token',$tokens)
                ->get();
            return response()->json([
                'status' => 200,
                'data' => $attendance
            ]);
        }
        catch (Exception $exception)
        {
            return response()->json([
                'status' => 404,
                'message' => '未知错误'
            ]);
        }

    }

}