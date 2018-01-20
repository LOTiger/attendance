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
use Bican\Roles\Models\Permission;
use Bican\Roles\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Psy\Util\Json;

class DepartmentsService extends Service
{

    /**
     * 返回修改视图
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEditRolePage(Request $request)
    {
        $id = null;
        if ($request->has('id'))
        {
            $this->checkNum($request->get('id'),true,new IllegaInputException());
            $id = $request->get('id');
        }
        return view('backend.admin.departments.index',compact('id'));
    }

    /**
     * 添加院系
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addDepartment(Request $request)
    {
        $this->validate($request, [
            'depar_name' => 'required|max:255',
            'description' => 'required|max:255',
        ]);


        $this->checkCan('add.department');

        $newRole = Department::query()->create([
            'depar_name' => $request->get('depar_name'),
            'desc' => $request->get('description'),
        ]);

        return redirect('backend/adddepartments')->with('tips' , ['icon'=>6,'msg'=>'添加成功']);
    }


    /**
     * 删除院系，待修改
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteDepartment(Request $request)
    {
        $this->validate($request,['id'=>'required']);
        $this->checkCan('delete.department',9);
        $this->checkNum($request->get('id'),true,new IllegaInputException());

        $department = Department::query()->find($request->get('id'));

        $department->delete();

        return response()->json(['state' => 1]);
    }


    /**
     * 修改院系
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editDepartment(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'depar_name' => 'required|max:255',
            'description' => 'required|max:255',
        ]);


        $this->checkCan('edit.department');
        $this->checkNum($request->get('id'),true,new IllegaInputException());

        $department = Department::query()->find($request->get('id'));
        $department->depar_name = $request->get('depar_name');
        $department->desc = $request->get('description');
        $department->save();

        return redirect()->back()->with('tips' , ['icon'=>6,'msg'=>'添加成功']);

    }


}