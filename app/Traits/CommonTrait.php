<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-13
 * Time: 上午12:53
 */

namespace App\Traits;


use App\Exceptions\PermissionDeniedException;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

trait CommonTrait
{
    /**
     * 检查用户是否拥有权限，第二个参数如果要检查level，就传进来
     * @param $permission
     * @param bool $checkLevel
     * @return bool
     */
    protected function canUserDo($permission,$checkLevel = false )
    {
        if ($checkLevel)
        {
            $user = User::query()->find(Auth::id());
            return $user->can($permission) && $user->level() >= $checkLevel;
        }
        else
        {
            return User::query()->find(Auth::id())->can($permission);
        }
    }

    /**
     * 检查用户是否有权限，没有权限则抛出异常
     * @param $permission
     * @param bool $checkLevel
     * @return bool
     * @throws PermissionDeniedException
     */
    protected function checkCan($permission,$checkLevel = false)
    {
        if ($this->canUserDo($permission,$checkLevel))
        {
            return true;
        }
        else
        {
            throw new PermissionDeniedException($permission);
        }
    }

    /**
     * 检查传入的参数是否为数字，同时做好异常抛出准备
     * @param $checkMsg
     * @param bool $throwException
     * @param null $exception
     * @return bool
     */
    protected function checkNum($checkMsg, $throwException = false , $exception = null)
    {
        return is_numeric($checkMsg)?
            true:($throwException?($this->throwException($exception)||true):true);
    }

    /**
     * 检查request过来的某个字段是否存在
     * @param Request $request
     * @param $checkString
     * @return bool
     */
    protected function checkExit(Request $request,$checkString)
    {
        return $request->has($checkString);
    }

    /**
     * 抛出异常
     * @param $exception
     */
    protected function throwException($exception)
    {
        throw $exception;
    }

    /**
     * 获得user实例
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function getUser($id)
    {
        return User::query()->find($id);
    }

    public function checkUserExit($stuNum)
    {
        return User::checkUserExit($stuNum);
    }

    public function getLessons($path)
    {
        return $this->cutLesson($this->getSeasonLessonArray($path));
    }

    public function cutLesson($data)
    {
        $r = [];
        foreach ($data as $key => $d)
        {
            if ($d)
            {
                foreach ($d as $k=> $l)
                {
                    $r[$key][$k] = $this->cutLessonString($l);
                    if ($l)
                        $r[$key][$k][1] = $this->getWeekBeginAndEnd($r[$key][$k][1]);
                }
            }
            else
            {
                $r[$key] = $d;
            }
        }
        return $r;
    }

    public function cutLessonString($lesson)
    {
        return explode("◇",$lesson);
    }

    public function getWeekBeginAndEnd($week)
    {
        $w = explode("(",$week);
        $r = explode("-",$w[0]);
        if (!is_numeric($r[1]))
        {
            $a = $r[1];
            preg_match('/\d+/',$a,$b);
            $r[1] = $b[0];
            $b = explode((string)$r[1],$a)[1];
            if ($b = '单') $r[2] = 1;
            elseif($b ='双')$r[2] = 2;
            else $r[2] = 0;
        }
        else
            $r[2] = 0 ;
        if (strstr($w[1],','))
            $r[3] = true;
        else
            $r[3] = false;
        return $r;
    }

    public function getSeasonLessonArray($path)
    {
        $lessonsData = array_slice(Excel::load($path)->ignoreEmpty()->get()->toArray()[0],2,6);
        $data = [];
        foreach ($lessonsData as $key => $lesson)
        {
            $data[$key] = array_slice($lesson, 2,5);
        }
        return $data;
    }


}