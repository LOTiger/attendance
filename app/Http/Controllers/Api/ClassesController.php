<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 18-1-22
 * Time: 下午7:13
 */

namespace app\Http\Controllers\Api;

use App\Models\Attendance;
use Dotenv\Exception\ValidationException;
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
            $students = Classes::query()->find($class_id)->students;
            foreach ($students as $key=>$student)
            {
                $students[$key]=[
                    'id' => $student->user->id,
                    'name' => $student->user->name,
                    'email' => $student->user->email,
                    'info' => [
                        'id' => $student->id,
                        'sign_num' => $student->sign_num,
                        'att_num' =>$student->att_num
                    ]
                ];
            }
            return response()->json([
                'status'=> 200,
                'data' => $students
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
}