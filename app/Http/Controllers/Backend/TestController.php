<?php

namespace App\Http\Controllers\Backend;

use App\Models\Attendance;
use App\Http\Controllers\Controller;
use App\Services\RsaService;

class TestController extends Controller
{
    /**
     * 插入十条考勤事件，随机插入学生出勤签到记录
     */
    public function insertAttendance()
    {
        for ($i=0;$i<10;$i++)
        {
            $class_id = \App\Models\Classes::all()->pluck('id')->random();
            $att = \App\Models\Attendance::query()->create([
                'att_token' => str_random(10),
                'class_id' => $class_id,
                'should' => \App\Models\Student::query()->where('class_id',$class_id)->get()->count(),
                'creator_id' => \App\Models\Teacher::all()->pluck('user_id')->random()
            ]);
            foreach (\App\Models\Student::query()->where('class_id',$class_id)->get() as $student)
            {
                if (rand(0,1)+0.2>0.5)
                {
                    \App\Models\SignIn::query()->create([
                        'stu_id' => $student->id,
                        'att_id' => $att->id
                    ]);
                    $att->real +=1;
                }
            }
            $att->status = 0;
            $att->save();
        }
    }

    /**
     * 获取总出勤率
     * @return float|int
     */
    public function getAttendance()
    {
        return Attendance::TotalAttendance();
    }

    /**
     * rsa加密解密调试
     */
    public function test()
    {
        $crypt = new RsaService();
        $crypt->select('rsa_api');
        $short = "123123xiao";
        $req['prikey'] = $crypt->prikey;
        $req['pubkey'] = $crypt->pubkey;
        $req['short'] = $short;
        $req['short_private_encrypt'] = $crypt->encryptPublic($short);
        $req['short_public_decrypt'] = $crypt->decryptPrivate('c4BysM47Fg96Nu1us3UBWnmWLHBE7/BagI9BltVBeb40zAUjzxxB/2JHB2JBRVRKgIWJoUJ8SjAZ3/S5x8wADOkQwVOvF8jwXN48j2BZ09bA1jPGzFf+7SEBsw/BEfV9mU4Gdp6KoCT06EAptZR9IHSDZ533PJ1sesdwg+IrfuQ=');
        dump($req);
    }

}
