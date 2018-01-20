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
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class ClassesService extends Service
{
    public function add(Request $request)
    {
        $this->validate($request,['data' => 'required|file']);
        $file = $request->file('data');
        $this->canUserDo('add.class');
        $clientName = $file -> getClientOriginalName().time();
        $savePath = $request->file('data')->store('classesData');
        $file_path  = 'storage/app/'.$savePath;
        return view('backend.admin.classes.dataReader',compact('file_path'));
    }

    public function import(Request $request)
    {
        $path = $request->get('path');
        $this->canUserDo('add.class');
        $excel_data = Excel::load($path)->ignoreEmpty()->get()->toArray();
        try
        {
            foreach ($excel_data as $key => $class)
            {
                $excel_data[$key]['专业']=$this->checkSpeNameExit($class['专业']);
            }
        }
        catch (IllegaDataInputException $e)
        {
            return redirect()->back()->with('tips' , ['icon'=>5,'msg'=>'专业名称异常']);
        }


        foreach ($excel_data as $class)
        {
            if (Classes::checkClassExit((int)$class['级别'],$class['专业'],(int)$class['班别']))
                continue;
            Classes::query()->create([
                'grade' => (int)$class['级别'],
                'class_num' => (int)$class['班别'],
                'spe_id' => $class['专业'],
                'desc' => '无',
            ]);
        }
        return redirect()->route('classes')->with('tips' , ['icon'=>6,'msg'=>'数据导入成功']);

    }

    public function export()
    {
        $cellData = [
            ['级别','专业','班别','所属院系'],
            ['15','计算机科学与技术',1 ,'信息工程系'],
            ['15','计算机科学与技术',2 ,'信息工程系'],
        ];
        Excel::create('班级数据例子',function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

    public function checkSpeNameExit($spe_name)
    {
        $id = Speciality::getSpeId($spe_name);
        if ($id)
        {
            return $id;
        }
        else
        {
            throw new IllegaDataInputException();
        }
    }
    public function checkDeparNameExit($depar_name)
    {
        $id = Department::getDeparId($depar_name);
        if ($id)
        {
            return $id;
        }
        else
        {
            throw new IllegaDataInputException();
        }
    }

    /**
     * 待修改
     * @param Request $request
     */
    public function delete(Request $request)
    {
        $this->validate($request,['id' => 'required']);
        $this->checkNum($request->get('id'),true,new IllegaInputException());
        $class = Classes::query()->find($request->get('id'));
        $class->delete();
        return response()->json(['state' => 1]);
    }




}