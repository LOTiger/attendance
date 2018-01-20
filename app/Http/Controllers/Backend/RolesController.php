<?php

namespace App\Http\Controllers\Backend;

use App\Exceptions\PermissionDeniedException;
use App\Services\RolesService;
use App\User;
use Illuminate\Http\Request;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{
    protected $rolesService, $request;

    /**
     * RolesController constructor.
     * @param RolesService $rolesService
     * @param Request $request
     */
    public function __construct(RolesService $rolesService, Request $request)
    {
        $this->rolesService = $rolesService;
        $this->request = $request;
    }

    /**
     * 返回角色修改视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return $this->rolesService->showEditRolePage($this->request);
    }

    /**
     * 返回角色添加视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAddForm()
    {
        return view('backend.admin.roles.add');
    }

    /**
     * 执行角色添加操作
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function add()
    {
        return $this->rolesService->addRole($this->request);
    }

    /**
     * 执行角色删除操作
     * @return string
     */
    public function delete()
    {
        return $this->rolesService->deleteRole($this->request);
    }

    /**
     * 执行角色修改操作
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit()
    {
        return $this->rolesService->editRole($this->request);
    }

    /**
     * 执行修改角色操作操作
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editRolePermissions()
    {
        return $this->rolesService->editRolePermission($this->request);
    }

}
