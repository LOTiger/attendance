<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-4
 * Time: 下午10:59
 */

namespace App\Services;

use App\Exceptions\IllegaInputException;
use App\Exceptions\PermissionDeniedException;
use App\Models\Department;
use App\Models\Speciality;
use Bican\Roles\Models\Permission;
use Bican\Roles\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Psy\Util\Json;

class SpecialitiesService extends Service
{

    /**
     * 返回修改视图
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEditPage(Request $request)
    {
        $this->validate($request, ['id' => 'required',]);
        $this->checkNum($request->get('id'),true,new IllegaInputException());
        $id = $request->get('id');
        return view('backend.admin.specialities.edit',compact('id'));
    }

    /**
     * 添加
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addSpeciality(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'required|max:255',
            'department' => 'required'
        ]);


        if ($this->CheckSpecialityExit($request->get('name')))
            return redirect()->back()->with('tips' , ['icon'=>5,'msg'=>'系名已存在'])->withInput();

        $this->checkCan('add.department');
        $this->checkNum($request->get('department'),true,new IllegaInputException());

        $newSpeciality = Speciality::query()->create([
            'spe_name' => $request->get('name'),
            'desc' => $request->get('description'),
            'depar_id' => $request->get('department'),
        ]);

        $newSpeciality->department()->associate($request->get('department'));

        return redirect('backend/specialities')->with('tips' , ['icon'=>6,'msg'=>'添加成功']);
    }


    /**
     * 删除，待修改
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteSpeciality(Request $request)
    {
        $this->validate($request,['id'=>'required']);
        $this->checkCan('delete.speciality');
        $this->checkNum($request->get('id'),true,new IllegaInputException());

        $speciality = Speciality::query()->find($request->get('id'));

        $speciality->delete();

        return response()->json(['state' => 1]);
    }


    /**
     * 修改
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editSpeciality(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'department' => 'required'
        ]);


        $this->checkCan('edit.department');
        $this->checkNum($request->get('id'),true,new IllegaInputException());


        $speciality = Speciality::query()->find($request->get('id'));
        $speciality->spe_name = $request->get('name');
        $speciality->desc = $request->get('description');
        $speciality->department()->dissociate();
        $speciality->department()->associate($request->get('department'));
        $speciality->save();




        return redirect()->back()->with('tips' , ['icon'=>6,'msg'=>'添加成功']);

    }

    public function CheckSpecialityExit($spe_name)
    {
        return Speciality::query()->where('spe_name',$spe_name)->count()>0?true:false;
    }

    public function getSpecialities(Request $request)
    {
        $this->validate($request,['id' => 'required|integer']);
        $specialities = Department::query()->find($request->get('id'))->speciality;
        if ($specialities->count()>0)
        {
            return response()->json($specialities);
        }
        else
        {
            return response()->json([]);
        }
    }


}