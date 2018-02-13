<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 18-2-5
 * Time: 上午1:01
 */

namespace App\Traits;


use App\Models\Attendance;
use App\Models\Classes;
use App\Models\Department;
use App\Models\Speciality;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Exception;

trait AttendanceTrait
{
    /**
     * 返回总出勤率
     * @return float|int
     */
    public static function TotalAttendance()
    {
        $allAtt = Attendance::all();
        return self::getAttendance($allAtt);
    }

    /**
     * 返回这个月的出勤率
     * @return float|int
     */
    public static function ThisMonthAttendance()
    {
        $Att = Attendance::query()
            ->whereYear('created_at',(int)date('Y'))
            ->whereMonth('created_at',(int)date('m'))->get();
        return self::getAttendance($Att);
    }

    /**
     * 获取某个系近n个月的考勤率
     * @param $depar_id
     * @param $Recent 最近几个月
     * @return null
     */
    public static function AttendanceOfDepartByMonth($depar_id,$Recent)
    {
        $spe_id = self::getSpeId($depar_id);
        $class_id =self::getClassesId($spe_id,false);
        $Att = DB::table('attendances')
            ->whereIn('class_id',$class_id)
            ->select('should','real',DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
            ->get()->groupBy('month');
        $data = null;
        try
        {
            foreach ($Att as $k => $a)
            {
                //筛选出近两年的
                $a->filter(function ($value, $key) {
                    return $value->year == (int)date('Y') || $value->year == (int)date('Y')-1;
                });
                if (self::checkRecentMonth($Recent,$k))
                    $data[$k] = self::getAttendance($a);
            }

            foreach(self::getRecentMonth($Recent) as $item)
            {
                if (!isset($data[$item]))
                {
                    $data[$item]=0;
                }
            }

            return $data;
        }
        catch (Exception $exception)
        {
            return $data;
        }
    }


    /**
     * 根据从数据库attendance表中获取出来的数据计算出勤率
     * @param Collection $att
     * @return float|int
     */
    protected static function getAttendance(Collection $att)
    {
        try
        {
            $Proportion = $att->reduce(function ($carry, $item) {
                return $carry+(float)$item->real/($item->should?$item->should:1);
            });
            return round($Proportion/$att->count()*100,2);
        }
        catch (Exception $exception)
        {
            return 0;
        }
    }

    /**
     * 检测是否是最近Recent月
     * @param $Recent
     * @param $key 需要检测的月份
     */
    protected static function checkRecentMonth($Recent,$key)
    {
        $month = (int)date('m');
        return ($month-$key<$Recent&&$month>=$key)||($key-$month>(12-$Recent)&&$month<$key);
    }

    /**
     * 获取近Recent个月的月份编号
     * @param $Recent
     * @return array
     */
    public static function getRecentMonth($Recent)
    {
        for ($i=0;$i<$Recent;$i++)
        {
            $time[]=(int)date('m',mktime(0,0,0,date('m')-$i));
        }
        return $time;
    }

    /**
     *获取某个系过去某一周的出勤率，默认为上一周
     * @param $depar_id
     * @param int $weekNum
     * @return float|int|null
     */
    public static function AttendanceOfDepartByWeek($depar_id,$weekNum=1)
    {
        $beginAndend = self::getWeekTime($weekNum);
        $spe_id = self::getSpeId($depar_id);
        $class_id =self::getClassesId($spe_id,false);
        $Att = self::AttendanceCollection($beginAndend[0],$beginAndend[1],$class_id);
        $data = null;
        try
        {
            $data = self::getAttendance($Att);
            return $data;
        }
        catch (Exception $exception)
        {
            return $data;
        }
    }

    /**
     * 获取周起始和结束时间
     * @param $Num 过去几周
     * @return array
     */
    protected static function getWeekTime($Num)
    {
        $begin=date('Y-m-d', mktime(0,0,0,date('m'),date('d')-date('w')+1-7*$Num,date('Y')));
        $end=date('Y-m-d',mktime(23,59,59,date('m'),date('d')-date('w')+7-7*$Num,date('Y')));
        return [$begin,$end];
    }
    /**
     * 获取月起始和结束时间
     * @param $Num 过去几个月
     * @return array
     */
    protected static function getMonthTime($Num)
    {
        $begin=date("Y-m-d",mktime(0, 0 , 0,date("m")-$Num,1,date("Y")));
        $end=date("Y-m-d",mktime(23,59,59,date("m")-$Num+1,0,date("Y")));
        return [$begin,$end];
    }

    /**
     * 获取班级id
     * @param $spe_id 系id
     * @param bool $groupByGrade 是否按年级分组，默认为是
     * @return array|\Illuminate\Database\Eloquent\Collection|static|static[]
     */
    public static function getClassesId($spe_id,$groupByGrade=true)
    {
        $classes = Classes::query()->whereIn('spe_id',$spe_id)->get();
        if (!$groupByGrade)
        {
            return $classes->pluck('id')->toArray();
        }
        else
        {
            $classes = $classes->groupBy('grade');

            foreach ($classes as $key=>$class)
            {
                $classes[$key]=$classes[$key]->reduce(function ($carry,$item){
                    $carry[]=$item->id;
                    return $carry;
                });
            }
            return $classes;
        }
    }

    /**
     * 获取考勤事件的collection
     * @param $begin
     * @param $end
     * @param $classes_id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function AttendanceCollection($begin,$end,$classes_id)
    {
        return Attendance::query()
            ->whereIn('class_id',$classes_id)
            ->whereBetween('created_at',[$begin,$end])
            ->get();
    }

    /**
     * 通过系id获取专业id
     * @param $depar_id
     * @return array
     */
    public static function getSpeId($depar_id)
    {
        return Speciality::query()->where('depar_id',$depar_id)->get()->pluck('id')->toArray();
    }

    /**
     * 根据系id获取各年级的系出勤率
     * @param $depar_id
     * @param $begin
     * @param $end
     * @return null
     */
    public static function AttendanceOfDeparGroupByGrade($depar_id,$begin,$end)
    {
        $spe_id=self::getSpeId($depar_id);
        $class_id = self::getClassesId($spe_id);
        $data = null;
        foreach ($class_id as $key=>$item)
        {
            $data[$key] = self::getAttendance(self::AttendanceCollection($begin,$end,$item));
        }
        return $data;
    }

    /**
     * 获取上周各年级的系出勤率
     * @return null
     */
    public static function getAttOfDepartGroupByGradeInLastWeek()
    {
        $departments = Department::all();
        $data = null;
        $beginAndEnd = self::getWeekTime(1);
        foreach ($departments as $department)
        {
            $data[$department->depar_name] = self::AttendanceOfDeparGroupByGrade($department->id,$beginAndEnd[0],$beginAndEnd[1]);
        }
        return $data;
    }

    /**
     * 获取上周各班的出勤率
     * @return null
     */
    public static function getAttOfClassGroupByGradeInLastWeek()
    {
        $departments = Department::all();
        $data = null;
        $beginAndEnd = self::getWeekTime(1);
        foreach ($departments as $department)
        {
            $data[$department->depar_name] = self::AttendanceOfClassGroupByGrade($department->id,$beginAndEnd[0],$beginAndEnd[1]);
        }
        return $data;
    }

    /**
     * 根据系id获取各班出勤率
     * @param $depar_id
     * @param $begin
     * @param $end
     * @return null
     */
    protected static function AttendanceOfClassGroupByGrade($depar_id,$begin,$end)
    {
        $spe_id=self::getSpeId($depar_id);
        $classes_id = self::getClassesId($spe_id);
        $data = null;
        foreach ($classes_id as $key=>$item)
        {
            foreach ($item as $class_id)
            {
                $classOfGrade = self::AttendanceCollection($begin,$end,is_array($class_id)?$class_id:[$class_id]);
                if (!$classOfGrade->isEmpty())
                {
                    $data[$key][Classes::getClassName($class_id)] = self::getAttendance(self::AttendanceCollection($begin,$end,$classOfGrade));
                }
                else
                {
                    $data[$key][Classes::getClassName($class_id)] = 0;
                }
            }
        }
        return $data;
    }

    public static function getAttOfClassGroupByGradeInLastMonth()
    {
        $departments = Department::all();
        $data = null;
        $beginAndEnd = self::getMonthTime(1);
        foreach ($departments as $department)
        {
            $data[$department->depar_name] = self::AttendanceOfClassGroupByGrade($department->id,$beginAndEnd[0],$beginAndEnd[1]);
        }
        return $data;
    }

    public static function getAttOfDepartGroupByGradeInLastMonth()
    {
        $departments = Department::all();
        $data = null;
        $beginAndEnd = self::getMonthTime(1);
        foreach ($departments as $department)
        {
            $data[$department->depar_name] = self::AttendanceOfDeparGroupByGrade($department->id,$beginAndEnd[0],$beginAndEnd[1]);
        }
        return $data;
    }

}