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
use App\User;
use Bican\Roles\Models\Permission;
use Bican\Roles\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PermissionsService extends Service
{


    /**
     * 执行添加操作
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function add(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
        ]);
        $this->checkCan('add.permissions');

        if (!($this->checkPermissionExit($request)))
        {
            return redirect()->back()->withErrors(['slug' => '该识别名已存在'])->withInput();
        }

        $newPermission = Permission::query()->create([
            'name' => $request->get('name'),
            'slug' => $request->get('slug'),
            'description' => $request->get('description'),
        ]);

        $this->attachRoleArray($newPermission,$request);
        return redirect('backend/permissions')->with('tips' , ['icon'=>6,'msg'=>'添加成功']);
    }

    /**
     * 检查操作英文拓展名是否已存在
     * @param Request $request
     * @return bool
     */
    protected function checkPermissionExit(Request $request)
    {
        $allPermissions = Permission::all();

        foreach ($allPermissions as $p)
        {
            if ($p->slug == $request->get('slug'))
            {
                return false;
            }
        }
        return true;
    }

    /**
     * 批量给角色添加操作
     * @param Role $role
     * @param Request $request
     */
    protected function attachRoleArray(Permission $permission,Request $request)
    {
        if (!empty($request->get('roles')))
        {
            foreach ($request->get('roles') as $roleId)
            {
                Role::query()->find($roleId)->attachPermission($permission);
            }
        }
    }

    /**
     * 返回修改视图
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bindRoleForm(Request $request)
    {
        $this->validate($request,['id'=>'required']);
        $this->checkNum($request->get('id'),true,new IllegaInputException());
        $id = $request->get('id');
        return view('backend.admin.permissions.edit',compact('id'));

    }

    /**
     * 执行修改操作
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'name' => 'required',
            'description' => 'required',
        ]);
        $this->checkCan('edit.permissions');
        $this->checkNum($request->get('id'),true,new IllegaInputException());

        if (!($this->checkPermissionExit($request)))
        {
            return redirect()->back()->withErrors(['slug' => '该识别名已存在'])->withInput();
        }

        if (is_numeric($request->get('id')))
        {
            return $this->doEditAction($request);
        }
    }

    /**
     * 执行修改操作并返回视图
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function doEditAction(Request $request)
    {
        $this->updatePermission($request);
        $this->updateRoles($request);
        return redirect('backend/permissions')->with('tips',['icon' => 6,'msg' => '修改成功']);
    }

    /**
     * 更新操作
     * @param Request $request
     * @return bool
     */
    protected function updatePermission(Request $request)
    {
        $permission = Permission::query()->find($request->get('id'));
        $permission->name = $request->get('name');
        $permission->description = $request->get('description');
        $permission->save();
        return true;
    }

    /**
     * 更新操作所绑定的角色
     * @param Request $request
     */
    protected function updateRoles(Request $request)
    {
        Permission::query()->find($request->get('id'))->detachAllRole();
        if ($request->has('roles'))
        {
            foreach ($request->get('roles') as $role_id)
            {
                Role::query()->find($role_id)->attachPermission($request->get('id'));
            }
        }
    }

    /**
     * 删除操作
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $this->validate($request,['id'=>'required']);
        $this->checkCan('delete.permission',9);
        $this->checkNum($request->get('id'),true,new IllegaInputException());

        $permission = Permission::query()->find($request->get('id'));

        $permission->detachAllRole();

        $permission->detachAllUser();

        $permission->delete();

        return response()->json(['state' => 1]);

    }
}