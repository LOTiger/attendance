<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 18-1-22
 * Time: 下午7:13
 */

namespace app\Http\Controllers\Api;

use App\Models\Attendance;
use Exception;
use App\Http\Controllers\Controller;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClassesController extends Controller
{


    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * 获取学生
     * @param $class_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStudents($class_id)
    {
        try
        {
            $class = Classes::query()->find($class_id);
            if (!empty($class))
            {
                $students = $class->students;
                foreach ($students as $key=>$student)
                {
                    $students[$key]=[
                        'id' => $student->user->id,
                        'name' => $student->user->name,
                        'account' => $student->user->account,
                        'email' => $student->user->email,
                        'headshot' => $student->user->headshot,
                        'info' => [
                            'id' => $student->id,
                            'sign_num' => $student->sign_num,
                            'att_num' =>$student->att_num,
                            'leave_num' =>$student->leave_num,
                        ]
                    ];
                }
                return response()->json([
                    'status'=> 200,
                    'data' => $students
                ]);
            }
            else
            {
                return response()->json([
                    'status'=> 404,
                    'message' => '班级不存在'
                ]);
            }

        }
        catch (Exception $exception)
        {
            return response()->json([
                'status'=> 404,
                'message' => '数据获取异常'
            ]);
        }
    }

    public function getAttendanceByClbumIdAndStatus($class_id)
    {

        try{
            $this->validate($this->request,[
                'status' => ['required',Rule::in([0,1])]
            ]);
        }
        catch (Exception $exception)
        {
            return response()->json([
                'status' => 404,
                'message' => '数据不符合规范'
            ]);
        }

        try
        {
            $attendances = Attendance::query()
                ->where('class_id',$class_id)
                ->where('status',$this->request->get('status'))
                ->get();

            return response()->json([
                'status'=> 200,
                'data' => $attendances
            ]);
        }
        catch (Exception $exception)
        {
            return response()->json([
                'status'=> 404,
                'message' => '数据获取异常'
            ]);
        }
    }

    public function getLessons($class_id)
    {
        try
        {
            $class = Classes::query()->find($class_id);
            if (!empty($class))
            {
                $lessons = $class->getStatusInLessons();
                foreach ($lessons as $key=>$lesson)
                {
                    $lessons[$key]->room->build = $lesson->room->build;
                    $lessons[$key]->classes->speciality->department = $lesson->classes->speciality->department;
                    $lessons[$key]->teacher->user = $lesson->teacher->user;
                }
                $lessons = array_flatten((Array)$lessons);
                return response()->json([
                    'status'=> 200,
                    'data' => $lessons
                ]);
            }
            else
            {
                return response()->json([
                    'status'=> 404,
                    'message' => '班级不存在'
                ]);
            }

        }
        catch (Exception $exception)
        {
            return response()->json([
                'status'=> 404,
                'message' => '数据获取异常'
            ]);
        }
    }
}