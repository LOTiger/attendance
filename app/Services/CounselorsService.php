<?php
/**
 * Created by PhpStorm.
 * User: GeChan
 * Date: 2018/1/26
 * Time: 11:07
 */

namespace App\Services;

use App\Exceptions\IllegaDataInputException;
use App\Exceptions\IllegaInputException;
use App\Models\Build;
use App\Models\Classes;
use App\Models\Teacher;
use App\Models\Counselor;
use App\Models\Department;
use App\Models\Room;
use Bican\Roles\Models\Role;
use App\Models\Speciality;
use App\User;
use function GuzzleHttp\Promise\all;
use function GuzzleHttp\Promise\queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Overtrue\Pinyin\Pinyin;

class CounselorsService extends Service
{
    protected $pinyin;
    public function __construct(Pinyin $pinyin)
    {
        $this->pinyin = $pinyin;
    }

    public function index(Request $request)
    {
        $id = null;
        if ($request->has('id'))
        {
            $this->checkNum($request->get('id'),true,new IllegaInputException());
            $id = $request->get('id');
        }
        return view('backend.admin.counselors.index',compact('id'));
    }

    public function showEditForm(Request $request)
    {
        $this->validate($request,['id'=>'required|integer']);
        $id = $request->get('id');
        return view('backend.admin.counselors.counselors',compact('id'));
    }

    public function showAddForm(Request $request)
    {

        return view('backend.admin.counselors.add');
    }


    /**
     * 返回修改视图
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showUpadateForm(Request $request)
    {
        $this->validate($request, ['id' => 'required',]);
        $this->checkNum($request->get('id'),true,new IllegaInputException());
        $id = $request->get('id');
        return view('backend.admin.counselors.edit',compact('id'));
    }

    /**
     * 帐号为学号，密码为工号加姓的拼音
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addCounselor(Request $request)
    {
        $this->validate($request,[

            'department' => 'required|integer',
            'counselor_name' => 'required|string',
            'user_id' => 'required|integer',

        ]);
        $this->checkCan('add.counselor');
        $department_id = $request->get('department');
        $counselor_name = $request->get('counselor_name');
        $user_id = $request->get('user_id');
            if (User::checkUserExit( $user_id));
            else {
                $user = User::query()->create([
                    'email' => (int)$user_id,
                    'name' => $counselor_name,
                    'password' => bcrypt((int)$user_id . $this->pinyin->name($counselor_name)[0])
                ]);

            $user->attachRole(Role::query()->where('slug','counselor')->get());
            $user->attachCounselor($department_id);



            }
        return redirect()->route('counselors')->with('tips' , ['icon'=>6,'msg'=>'数据导入成功']);

    }

    public function editCounselor(Request $request)
    {

        $this->checkCan('edit.counselor');
        $this->validate($request,[
            'user_id'=> 'required|integer',
            'department' => 'required|integer',
        ]);
        $user_id = $request->user_id;
        $depar_id = $request->department;

        Counselor::where('user_id',  $user_id)->update(['depar_id' => $depar_id]);

        return redirect()->back()->with('tips' , ['icon'=>6,'msg'=>'辅导员信息更新成功']);


    }

    public function deleteCounselor(Request $request)
    {

        $this->checkCan('delete.counselor');
        $this->validate($request,[
            'id' => 'required|integer',
        ]);
        $id = $request->get('id');

        User::query()->find($request->get('id'))->delete();
        return response()->json(['state' => 1]);
    }


    public function showClasses(Request $request)
    {
        $this->validate($request, ['id' => 'required',]);
        $this->checkNum($request->get('id'),true,new IllegaInputException());
        $id = $request->get('id');

        return view('backend.admin.counselors.classes',compact('id'));
    }

    public function showaddClasses()
    {
        return view('backend.admin.counselors.addclasses');
    }

    public function counseloraddclass(Request $request)
    {
        $this->checkCan('counselor.add.class');
        $this->validate($request,[
            'counselor' => 'required|integer',
        ]);
        $user_id = $request->get('counselor');
        $counselor_id = Counselor::where('user_id', '=', $user_id)->first();
        $class_id = $request->get('checkbox1');
        Classes::whereIn('id',$class_id)-> update(['counselor_id' =>$counselor_id->id]);
        return redirect()->route('show.add.classes')->with('tips' , ['icon'=>6,'msg'=>'班级添加成功']);
    }



    public function getclassinfo(Request $request)
    {
        $this->validate($request,['id' => 'required|integer']);
        $counselors= Counselor::select('user_id')->where('depar_id',$request->id)->get();
        $counselor = User::whereIn('id', $counselors)->get();

        if ($counselor->count()>0)
        {
            return response()->json($counselor);
        }
        else
        {
            return response()->json([]);
        }

    }

    public function showcounselorclass(Request $request)
    {
        $this->validate($request, ['id' => 'required',]);
        $this->checkNum($request->get('id'),true,new IllegaInputException());
        $id = $request->get('id');
        return view('backend.admin.counselors.editclass',compact('id'));
    }


    public function editcounselorclass(Request $request)
    {
        $this->checkCan('counselor.edit.class');
        $this->validate($request,[
            'counselor' => 'required|integer',
            'id'=> 'required|integer'
        ]);
        $user_id = $request->get('counselor');
        $counselor_id = Counselor::where('user_id', '=', $user_id)->first();
        Classes::where('id',$request->id)-> update(['counselor_id' =>$counselor_id->id]);
        return redirect()->back()->with('tips' , ['icon'=>6,'msg'=>'班级修改成功']);

    }
}
