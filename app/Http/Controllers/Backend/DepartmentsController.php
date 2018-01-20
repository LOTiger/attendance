<?php

namespace App\Http\Controllers\Backend;

use App\Exceptions\PermissionDeniedException;
use App\Models\Department;
use App\Services\DepartmentsService;
use App\Services\RolesService;
use App\User;
use Illuminate\Http\Request;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DepartmentsController extends Controller
{
    protected $departmentsService, $request;

    /**
     * RolesController constructor.
     * @param RolesService $rolesService
     * @param Request $request
     */
    public function __construct(DepartmentsService $departmentsService, Request $request)
    {
        $this->departmentsService = $departmentsService;
        $this->request = $request;
    }

    /**
     * 返回修改视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return $this->departmentsService->showEditRolePage($this->request);
    }

    /**
     * 返回添加视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAddForm()
    {
        return view('backend.admin.departments.add');
    }

    /**
     * 执行添加操作
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function add()
    {
        return $this->departmentsService->addDepartment($this->request);
    }

    /**
     * 执行删除操作
     * @return string
     */
    public function delete()
    {
        return $this->departmentsService->deleteDepartment($this->request);
    }

    /**
     * 执行修改操作
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit()
    {
        return $this->departmentsService->editDepartment($this->request);
    }


}
