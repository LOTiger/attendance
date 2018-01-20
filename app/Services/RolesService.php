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
use Bican\Roles\Models\Permission;
use Bican\Roles\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Psy\Util\Json;

class RolesService extends Service
{
    public function __construct()
    {

    }

    /**
     * 返回角色修改视图
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
        return view('backend.admin.roles.index',compact('id'));

    }

    /**
     * 执行角色添加操作
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws IllegaInputException
     * @throws PermissionDeniedException
     */
    public function addRole(Request $request)
    {
         $this->validate($request, [
            'name' => 'required|max:255',
            'slug' => 'required',
            'description' => 'required',
            'level' => 'required|max:9|min:0',
        ]);


        $this->checkCan('add.role');
        $this->checkNum($request->get('level'),true,new IllegaInputException());
        if (!($this->checkRoleExit($request)))
        {
            return redirect()->back()->withErrors(['slug' => '该识别名已存在'])->withInput();
        }

        $newRole = Role::query()->create([
            'name' => $request->get('name'),
            'slug' => $request->get('slug'),
            'description' => $request->get('description'),
            'level' => $request->get('level'),
        ]);

        $this->attachPermissionArray($newRole,$request);

        return redirect('backend/addroles')->with('tips' , ['icon'=>6,'msg'=>'添加成功']);


    }


    /**
     * 执行角色修改操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws IllegaInputException
     * @throws PermissionDeniedException
     */
    public function editRole(Request $request)
    {
         $this->validate($request, [
            'id' => 'required',
            'name' => 'required|max:255',
            'slug' => 'required',
            'description' => 'required',
            'level' => 'required|max:9|min:0',
        ]);
        $this->checkCan('edit.role');
        $this->checkNum($request->get('id'),true,new IllegaInputException());

        if (!($this->checkRoleExit($request)))
        {
            return redirect()->back()->withErrors(['slug' => '该识别名已存在'])->withInput();
        }
        $role = Role::query()->find($request->get('id'));
        $role->name = $request->get('name');
        $role->slug = $request->get('slug');
        $role->description = $request->get('description');
        $role->level = $request->get('level');
        $role->save();
        return redirect()->back()->with('tips' , ['icon'=>6,'msg'=>'修改成功']);

    }

    /**
     * 执行角色删除操作
     * @param Request $request
     * @return string
     */
    public function deleteRole(Request $request)
    {
        if ($this->canUserDo('delete.role'))
        {
            $this->validate($request,[
                'id' => 'required|integer',
            ]);
            Role::query()->find($request->id)->delete();
            Log::warning("使用者id:".Auth::id()."执行了删除角色操作，删除了id为".$request->id.",操作名为delete.role的操作");
            return Json::encode(['state' => 1]);
        }
        else
        {
            Log::error("使用者id:".Auth::id()."企图越权执行删除角色操作，只可惜操作被禁止了。");
            return Json::encode(['state' => 0]);
        }
    }


    /**
     * 检查角色英文拓展名是否已存在
     * @param Request $request
     * @return bool
     */
    protected function checkRoleExit(Request $request)
    {
        $allRoles = Role::all();

        foreach ($allRoles as $r)
        {
            if ($request->has('id') && $r->id == $request->get('id'))
                continue;
            if ($r->slug == $request->get('slug'))
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
    protected function attachPermissionArray(Role $role,Request $request)
    {
        if (!empty($request->get('permissions')))
        {
            foreach ($request->get('permissions') as $permissionId)
            {
                $role->attachPermission($permissionId);
            }
        }
    }

    /**
     * 修改角色操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editRolePermission(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);
        return $this->checkHasPermissionAndUpdate($request);

    }

    /**
     * 检查角色所拥有的操作，并且更新
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws IllegaInputException
     * @throws PermissionDeniedException
     */
    protected function checkHasPermissionAndUpdate(Request $request)
    {

        $this->checkCan('edit.permissions');
        $this->checkNum($request->get('id'),true,new IllegaInputException());

        $role = Role::query()->find($request->id);
        //获得该角色拥有的操作
        $rolePermissions = $role->permissions;
        //判断该角色拥有的操作是否为空

        if ($rolePermissions->isEmpty())
        {
            $this->foreachAddPermission($request, $role);
        }
        else
        {
            $this->updateRolePermissions($request, $role);
        }
        return redirect()->back()->with('tips' , ['icon'=>6,'msg'=>'更新成功']);

    }

    /**
     * 更新角色操作
     * @param Request $request
     * @param Role $role
     * @return bool
     * @throws IllegaInputException
     */
    protected function updateRolePermissions(Request $request,Role $role)
    {

        $rolePermissions = $role->permissions;
        //判断是否选择了操作，没有则一个一个移除现有的操作
        if ($request->has('permissions'))
        {
            //判断获取的是否是数组，否则抛出异常
            if(is_array($request->get('permissions')))
            {
                $role->detachAllPermission();
                $this->foreachAddPermission($request, $role);
            }
            else
            {
                throw new IllegaInputException("PermissionsService row 56 has something error, but i don't know
                                 how to describe it----lotiger");
            }
        }
        else
        {
            $role->detachAllPermissions();
        }
        return true;
    }

    /**
     * 循环给角色添加操作
     * @param Request $request
     * @param Role $role
     * @param bool $checkExit
     * @return bool
     */
    protected function foreachAddPermission(Request $request, Role $role)
    {

        foreach ($request->get('permissions') as $permission)
        {
            $role->attachPermission($permission);
        }
        return true;
    }



}