<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-4
 * Time: 下午10:59
 */

namespace App\Services;

use App\Exceptions\IllegaDataInputException;
use App\Exceptions\IllegaInputException;
use App\Models\Classes;
use App\Models\Department;
use App\Models\Speciality;
use App\User;
use Bican\Roles\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Overtrue\Pinyin\Pinyin;
use Exception;

class StudentsService extends Service
{
    protected $pinyin;
    public function __construct(Pinyin $pinyin)
    {
        $this->pinyin = $pinyin;
    }
    public function add(Request $request)
    {
        $this->validate($request,[
            'grade' => 'required|integer',
            'speciality' => 'required|integer',
            'class' => 'required|integer',
            'data' => 'required|file'
        ]);
        $this->checkCan('add.students');

        $classId =Classes::getClassId($request->get('grade'),$request->get('speciality'),$request->get('class'));
        if ($classId)
        {
            $savePath = $request->file('data')->store('studentsData');
            $file_path  = 'storage/app/'.$savePath;
            return view('backend.admin.students.dataReader',compact('file_path','classId'));
        }
        else
        {
            return back()->with('tips' , ['icon'=>5,'msg'=>'班级不存在']);
        }
    }


    /**
     * 学生帐号为学号，密码为学号加姓的拼音
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        $this->validate($request,[
            'path' => 'required|string',
            'classId' => 'required|Integer'
        ]);
        $path = $request->get('path');
        $classId = $request->get('classId');
        $this->checkCan('add.students');
        $excel_data = Excel::load($path)->ignoreEmpty()->get()->toArray();

        try
        {
            foreach ($excel_data as $student)
            {
                if (User::checkUserExit((int)$student[0]))
                    continue;
                $user = User::query()->create([
                    'account' => (int)$student[0],
                    'name' => $student[1],
                    'password' => bcrypt((int)$student[0].$this->pinyin->name($student[1])[0])
                ]);
                $user->attachRole(Role::query()->where('slug','student')->get());
                $user->attachStudent($classId);
            }
            $this->updateClassStuNum($classId);
            return redirect()->route('students')->with('tips' , ['icon'=>6,'msg'=>'数据导入成功']);
        }
        catch (Exception $exception)
        {
            dd($exception);
            return back()->with('tips' , ['icon'=>5,'msg'=>'未知错误']);
        }

    }

    public function updateClassStuNum($class_id)
    {
        $class = Classes::query()->find($class_id);
        $stu_num = collect($class->students)->count();
        $class->stu_num = $stu_num;
        $class->save();
    }

}