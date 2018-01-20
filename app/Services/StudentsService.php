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

        foreach ($excel_data as $student)
        {
            if (User::checkUserExit($student['学号']))
                continue;
            $user = User::query()->create([
                'email' => (int)$student['学号'],
                'name' => $student['姓名'],
                'password' => bcrypt((int)$student['学号'].$this->pinyin->name($student['姓名'])[0])
            ]);
            $user->attachRole(Role::query()->where('slug','student')->get());
            $user->attachStudent($classId);
        }
        return redirect()->route('students')->with('tips' , ['icon'=>6,'msg'=>'数据导入成功']);

    }

}