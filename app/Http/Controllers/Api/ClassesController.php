<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 18-1-22
 * Time: 下午7:13
 */

namespace app\Http\Controllers\Api;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Classes;

class ClassesController extends Controller
{
    public function getStudents($class_id)
    {
        try
        {
            $students = Classes::query()->find($class_id)->students;
            foreach ($students as $key=>$student)
            {
                $students[$key]['user']=$student->user;
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
}