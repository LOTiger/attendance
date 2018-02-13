<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 18-2-7
 * Time: 下午7:57
 */

namespace App\Services;


use App\Models\Attendance;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class DashboardService extends Service
{
    public $request;
    protected $attendance;

    public function __construct(Request $request,Attendance $attendance)
    {
        $this->attendance = $attendance;
        $this->request = $request;
    }
    public function getChartData()
    {
        $departments= Department::all();
        $data = null;
        $data['labels'] = array_reverse(Attendance::getRecentMonth(6));
        foreach ($departments as $key=>$department)
        {
            $data['data'][$key]['label'] = $department->depar_name;
            $data['data'][$key]['data'] = Attendance::AttendanceOfDepartByMonth($department->id,6);
        }
        return response()->json($data);
    }

    public function dataReader()
    {
        $this->validate($this->request,[
            'time'=>['required',Rule::in(['week','month'])],
            'body'=>['required',Rule::in(['class,department'])]
        ]);
        $time=$this->request->get('time');
        $body=$this->request->get('body');
        return view('backend.admin.dashboard.datareader',compact('time','body'));
    }

    public function export()
    {
        $this->validate($this->request,[
            'time'=>['required',Rule::in(['week','month'])],
            'body'=>['required',Rule::in(['class,department'])]
        ]);
        $time=$this->request->get('time');
        $body=$this->request->get('body');
        dd($this->doExport($time,$body));

    }

    protected function doExport($time,$body)
    {
        if ($time=='week')
        {
            if ($body=='department')
            {
                return $this->AttendanceOrderOfDeparInLastWeek();
            }
            else
            {
                return $this->AttendanceOrderOfClassInLastWeek();
            }
        }
        else
        {
            if ($body=='department')
            {
                return $this->AttendanceOrderOfDeparInLastMonth();
            }
            else
            {
                return $this->AttendanceOrderOfClassInLastMonth();
            }
        }
    }

    /**
     * 不推荐阅读
     */
    protected function AttendanceOrderOfDeparInLastWeek()
    {
        $att = $this->attendance->getAttOfDepartGroupByGradeInLastWeek();
        $b=0;
        foreach ($att as $key=>$a)
        {
            foreach ($a as $k=>$v)
            {
                $d[$k][$b]['att'] = $v;
                $d[$k][$b]['depart'] = $key;
            }
            $b++;
        }
        Excel::create('系周出勤排名',function($excel) use ($d){
            foreach ($d as $key=>$value)
            {
                $value = collect($value)->sortByDesc('att');
                $excel->sheet($key.'级系出勤排名', function($sheet) use ($value){
                    $sheet->row(1, array(
                        '系名', '出勤率','排名'
                    ));
                    $num=1;
                    foreach ($value as $cell)
                    {
                        $sheet->row($num+1,[$cell['depart'],$cell['att'].'%',$num++]);
                    }
                });
            }
        })->export('xlsx');
    }

    protected function AttendanceOrderOfClassInLastWeek()
    {
        $att = $this->attendance->getAttOfClassGroupByGradeInLastWeek();
        $d = null;
        $b=0;
        foreach ($att as $key=>$a)
        {
            foreach ($a as $k=>$v)
            {
                foreach ($v as $e=>$f)
                {
                    $d[$key][$k][$b]['att'] = $f;
                    $d[$key][$k][$b]['class'] = $e;
                    $b++;
                }
            }
        }

        Excel::create('班出勤排名',function($excel) use ($d){
            foreach ($d as $key=>$value)
            {
                foreach ($value as $k=>$v)
                {
                    $excel->sheet($k.'级上周班出勤排名', function($sheet) use ($v){
                        $v = collect($v)->sortByDesc('att');
                        $sheet->row(1, array(
                            '名次', '班级','出勤率'
                        ));
                        $num=2;
                        foreach ($v as $kk => $cell)
                        {
                            $sheet->row($num,[$num-1,$cell['class'],$cell['att'].'%']);
                            $num++;
                        }
                    });
                }
            }
        })->export('xlsx');

    }

    protected function AttendanceOrderOfDeparInLastMonth()
    {
        $att = $this->attendance->getAttOfDepartGroupByGradeInLastMonth();
        $b=0;
        foreach ($att as $key=>$a)
        {
            foreach ($a as $k=>$v)
            {
                $d[$k][$b]['att'] = $v;
                $d[$k][$b]['depart'] = $key;
            }
            $b++;
        }
        Excel::create((date('m')-1).'月系出勤排名',function($excel) use ($d){
            foreach ($d as $key=>$value)
            {
                $value = collect($value)->sortByDesc('att');
                $excel->sheet($key.'级系出勤排名', function($sheet) use ($value){
                    $sheet->row(1, array(
                        '系名', '出勤率','排名'
                    ));
                    $num=1;
                    foreach ($value as $key => $cell)
                    {
                        $sheet->row($num+1,[$cell['depart'],$cell['att'].'%',$num++]);
                    }
                });
            }
        })->export('xlsx');
    }

    protected function AttendanceOrderOfClassInLastMonth()
    {
        $att = $this->attendance->getAttOfClassGroupByGradeInLastMonth();
        $d = null;
        $b=0;
        foreach ($att as $key=>$a)
        {
            foreach ($a as $k=>$v)
            {
                foreach ($v as $e=>$f)
                {
                    $d[$key][$k][$b]['att'] = $f;
                    $d[$key][$k][$b]['class'] = $e;
                    $b++;
                }
            }
        }

        Excel::create('班出勤排名',function($excel) use ($d){
            foreach ($d as $key=>$value)
            {
                foreach ($value as $k=>$v)
                {
                    $excel->sheet($k.'级'.$key.(date('m')-1).'月班出勤排名', function($sheet) use ($v){
                        $v = collect($v)->sortByDesc('att');
                        $sheet->row(1, array(
                            '名次', '班级','出勤率'
                        ));
                        $num=2;
                        foreach ($v as $kk => $cell)
                        {
                            $sheet->row($num,[$num-1,$cell['class'],$cell['att'].'%']);
                            $num++;
                        }
                    });
                }
            }
        })->export('xlsx');
    }

}