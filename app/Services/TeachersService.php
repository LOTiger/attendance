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

class TeachersService extends Service
{
    protected $pinyin;
    public function __construct(Pinyin $pinyin)
    {
        $this->pinyin = $pinyin;
    }
    public function add(Request $request)
    {
        $this->validate($request,[
            'speciality' => 'required|integer',
            'data' => 'required|file'
        ]);
        $this->checkCan('add.teachers');
        $speId = $request->get('speciality');
        $savePath = $request->file('data')->store('teachersData');
        $file_path  = 'storage/app/'.$savePath;
        return view('backend.admin.teachers.dataReader',compact('file_path','speId'));
    }


    /**
     * 帐号为学号，密码为工号加姓的拼音
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        $this->validate($request,[
            'path' => 'required|string',
            'speId' => 'required|Integer'
        ]);
        $path = $request->get('path');
        $speId = $request->get('speId');
        $this->checkCan('add.teachers');
        $excel_data = Excel::load($path)->ignoreEmpty()->get()->toArray();

        foreach ($excel_data as $teacher)
        {
            if (User::checkUserExit($teacher['工号']))
                continue;
            $user = User::query()->create([
                'email' => (int)$teacher['工号'],
                'name' => $teacher['姓名'],
                'password' => bcrypt((int)$teacher['工号'].$this->pinyin->name($teacher['姓名'])[0])
            ]);
            $user->attachRole(Role::query()->where('slug','teacher')->get());
            $user->attachTeacher($speId);
        }
        return redirect()->route('teachers')->with('tips' , ['icon'=>6,'msg'=>'数据导入成功']);

    }

}