<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 18-2-5
 * Time: 上午12:43
 */

namespace App\Presenters;


use App\Models\Attendance;
use App\Models\Department;
use App\Models\Student;

class DashboardPresenter
{
    protected $attendance;
    public function __construct(Attendance $attendance)
    {
        $this->attendance = $attendance;
    }

    /**
     * 获取学生数
     * @return int
     */
    public function getStudentsCount()
    {
        return Student::all()->count();
    }

    /**
     * 获取考勤事件数
     * @return int
     */
    public function getAttendancesCount()
    {
        return $this->attendance->all()->count();
    }

    /**
     * 获取总出勤率，保留两位小数
     * @return float
     */
    public function getAttendance()
    {
        return $this->attendance->TotalAttendance();
    }

    /**
     * 获取本月出勤率
     * @return float
     */
    public function getAttendanceOfThisMonth()
    {
        return $this->attendance->ThisMonthAttendance();
    }

    public function thisMonthAttendanceByDepartment()
    {
        $data = '';
        $departments = $this->getDepartment();
        foreach ($departments as $department)
        {
            $att = $this->getAttendanceByDepartment($department->id);
            $data .=
                '<div class="progress-group">'
                    .'<span class="progress-text">'.$department->depar_name.'</span>'
                    .'<span class="progress-number">'.$att.'<small>%</small></span>'
                    .'<div class="progress sm">'
                        .'<div class="progress-bar '.$this->getBarString($att).'" style="width: '.$att.'%"></div>'
                    .'</div>
                </div>';
        }
        return $data;
    }

    protected function getAttendanceByDepartment($id)
    {
        return $this->attendance->AttendanceOfDepartByMonth($id,1)[(int)date('m')];
    }

    protected function getDepartment()
    {
        return Department::all();
    }

    /**
     * 根据出勤率获取进度条颜色
     * @param $att
     * @return string
     */
    protected function getBarString($att)
    {
        if ($att>=80&&$att<=100)
        {
            return 'progress-bar-green';
        }
        else if ($att>=70&&$att<80)
        {
            return 'progress-bar-blue';
        }
        else if ($att>=60&&$att<70)
        {
            return 'progress-bar-yellow';
        }
        else
        {
            return 'progress-bar-red';
        }
    }

    /**
     * 系出勤排名
     * @return string
     */
    public function attendanceOrder()
    {
        $data = '';
        $departments = $this->getDepartment();

        foreach ($departments as $key=>$department)
        {
            $d[$key]['att'] = $this->getAttendanceByDepartment($department->id);
            $d[$key]['name'] = $department->depar_name;
        }
        $d = collect($d)->sortByDesc('att');
        $num=1;
        foreach ($d as $item)
        {
            $state = $this->getClassString($item['att']);
            $data .=
                '<tr>'
                .'<td><a>'.$num.'</a></td>'
                .'<td>'.$item['name'].'</td>'
                .'<td><span class="label '.$state[0].'">'.$state[1].'</span></td>'
                .'<td>'
                .'<div class="sparkbar" data-height="20">'.$item['att'].'<small>%</small></div>'
                .'</td>
            </tr>';
            $num++;
        }
        return $data;

    }

    /**
     * 用与css的评价
     * @param $att
     * @return array
     */
    protected function getClassString($att)
    {
        if ($att>=80&&$att<=100)
        {
            return ['label-success','优'];
        }
        else if ($att>=60&&$att<80)
        {
            return ['label-warning','良'];
        }
        else
        {
            return ['label-danger','差'];
        }
    }


    public function dataReader($time,$body)
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
     * @return string
     */
    protected function AttendanceOrderOfDeparInLastWeek()
    {
        $data = '';
        $att = $this->attendance->getAttOfDepartGroupByGradeInLastWeek();
        $d = null;
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

        foreach ($d as $key=>$value)
        {
            $data .= '<h4>'.$key.'级第'.$this->getLastWeek().'周系出勤排名</h4>'
                .'<table class="table table-bordered table-striped table-hover">'
                .'<thead>'
                .'<tr>'
                    .'<th>名次</th>'
                    .'<th>系名</th>'
                    .'<th>出勤率</th>'
                .'</tr>'
                .'</thead>'
                .'<tbody>';
            $value = collect($value)->sortByDesc('att');

            $num = 1;
            foreach ($value as $k=>$v)
            {
                $data .=
                    '<tr>'
                    .'<td><a>'.$num.'</a></td>'
                    .'<td>'.$v['depart'].'</td>'
                    .'<td>'
                    .'<div class="sparkbar" data-height="20">'.$v['att'].'<small>%</small></div>'
                    .'</td>
                    </tr>';
                $num++;
            }
            $data .='</tbody>
                </table>';
        }
        return $data;
    }

    /**
     * 不推荐阅读
     * @return string
     */
    protected function AttendanceOrderOfClassInLastWeek()
    {
        $data = '';
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

        foreach ($d as $key=>$value)
        {
            $data .= '<h3>'.$key.'</h3>';
            foreach ($value as $k=>$v)
            {
                $data .= '<h4>'.$k.'级第'.$this->getLastWeek().'周班出勤排名</h4>'
                    .'<table class="table table-bordered table-striped table-hover">'
                    .'<thead>'
                    .'<tr>'
                    .'<th>名次</th>'
                    .'<th>班名</th>'
                    .'<th>出勤率</th>'
                    .'</tr>'
                    .'</thead>'
                    .'<tbody>';
                $v = collect($v)->sortByDesc('att');

                $num = 1;
                foreach ($v as $g=>$h)
                {
                    $data .=
                        '<tr>'
                        .'<td><a>'.$num.'</a></td>'
                        .'<td>'.$h['class'].'</td>'
                        .'<td>'
                        .'<div class="sparkbar" data-height="20">'.$h['att'].'<small>%</small></div>'
                        .'</td>
                    </tr>';
                    $num++;
                }
                $data .='</tbody>
                </table>';
            }
        }
        return $data;
    }

    /**
     * 不推荐阅读
     * @return string
     */
    protected function AttendanceOrderOfDeparInLastMonth()
    {
        $data = '';
        $att = $this->attendance->getAttOfDepartGroupByGradeInLastMonth();
        $d = null;
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

        foreach ($d as $key=>$value)
        {
            $data .= '<h4>'.$key.'级'.(date('m')-1<=0?(int)date('m')-1+12:(int)date('m')-1).'月份系出勤排名</h4>'
                .'<table class="table table-bordered table-striped table-hover">'
                .'<thead>'
                .'<tr>'
                .'<th>名次</th>'
                .'<th>系名</th>'
                .'<th>出勤率</th>'
                .'</tr>'
                .'</thead>'
                .'<tbody>';
            $value = collect($value)->sortByDesc('att');

            $num = 1;
            foreach ($value as $k=>$v)
            {
                $data .=
                    '<tr>'
                    .'<td><a>'.$num.'</a></td>'
                    .'<td>'.$v['depart'].'</td>'
                    .'<td>'
                    .'<div class="sparkbar" data-height="20">'.$v['att'].'<small>%</small></div>'
                    .'</td>
                    </tr>';
                $num++;
            }
            $data .='</tbody>
                </table>';
        }
        return $data;
    }

    /**
     * 不推荐阅读
     * @return string
     */
    protected function AttendanceOrderOfClassInLastMonth()
    {
        $data = '';
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

        foreach ($d as $key=>$value)
        {
            $data .= '<h3>'.$key.'</h3>';
            foreach ($value as $k=>$v)
            {
                $data .= '<h4>'.$k.'级'.(date('m')-1<=0?(int)date('m')-1+12:(int)date('m')-1).'月份班出勤排名</h4>'
                    .'<table class="table table-bordered table-striped table-hover">'
                    .'<thead>'
                    .'<tr>'
                    .'<th>名次</th>'
                    .'<th>班名</th>'
                    .'<th>出勤率</th>'
                    .'</tr>'
                    .'</thead>'
                    .'<tbody>';
                $v = collect($v)->sortByDesc('att');

                $num = 1;
                foreach ($v as $g=>$h)
                {
                    $data .=
                        '<tr>'
                        .'<td><a>'.$num.'</a></td>'
                        .'<td>'.$h['class'].'</td>'
                        .'<td>'
                        .'<div class="sparkbar" data-height="20">'.$h['att'].'<small>%</small></div>'
                        .'</td>
                    </tr>';
                    $num++;
                }
                $data .='</tbody>
                </table>';
            }
        }
        return $data;
    }

    public function getLastWeek()
    {
        $today =date('Y-m-d');
        $startDate = strtotime($today)>strtotime(config('settings.next_semester_start'))?config('settings.next_semester_start'):config('settings.last_semester_start');
        $startDay = date('w',strtotime($startDate));
        $limitDay = (strtotime($today) - strtotime($startDate))/(60*60*24);
        $weekNumber = ceil(($limitDay+$startDay) / 7);
        return (int)$weekNumber-1;
    }

    public function getSchoolYear()
    {
        $today =date('Y-m-d');
        return strtotime($today)>strtotime(config('settings.next_semester_start'))
            ?'下学期':'上学期';
    }

}