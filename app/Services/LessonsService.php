<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-4
 * Time: 下午10:59
 */

namespace App\Services;

use App\Models\Build;
use App\Models\Classes;
use App\Models\Lesson;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Overtrue\Pinyin\Pinyin;

class LessonsService extends Service
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
        $this->checkCan('add.lessons');

        $classId =Classes::getClassId($request->get('grade'),$request->get('speciality'),$request->get('class'));
        if ($classId)
        {
            $savePath = $request->file('data')->store('lessonsData');
            $file_path  = 'storage/app/'.$savePath;
            return view('backend.admin.lessons.dataReader',compact('file_path','classId'));
        }
        else
        {
            return back()->with('tips' , ['icon'=>5,'msg'=>'班级不存在']);
        }
    }


    /**
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
        $this->checkCan('add.lessons');
        $lessons = $this->getLessons($path);

        $this->addLesson($lessons,$classId);
        return redirect()->route('show.add.lessons.form')->with('tips' , ['icon'=>6,'msg'=>'数据导入成功']);

    }



    public function addLesson($data,$classId)
    {
        //修改该班课程状态

        Classes::query()->find($classId)->changeLessonStatus();

        $reLesson = Array();
        //每个lessons相当于周一到周五指定节次对应的课程
        foreach ($data as $key => $lessons)
        {
            foreach ($lessons as $k => $lesson)
            {
                if (empty($lesson[0]))
                    continue;
                $l=Array();

                if ($lesson[1][3])
                {
                    $l['section'] = pow(2,$key*2)+pow(2,$key*2+1);
                }
                else
                {
                    $l['section'] = pow(2,$key*2);
                }
                $l['name'] = trim($lesson[0]);
                $l['teacher_id'] = Teacher::getTeacherIdByWorkNum($lesson[3]);
                $l['week_begin'] = $lesson[1][0];
                $l['week_end'] = $lesson[1][1];
                $l['is_single'] =$lesson[1][2];
                $l['class_id'] = $classId;
                $l['weekday'] = $k;
                $l['room_id'] =Build::getRoomIdByName($lesson[2]);
                $reLesson[] = $l;

            }
        }
        foreach ($reLesson as $v)
        {
            Lesson::query()->create($v);
        }
    }



}