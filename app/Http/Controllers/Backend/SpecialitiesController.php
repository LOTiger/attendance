<?php

namespace App\Http\Controllers\Backend;

use App\Exceptions\PermissionDeniedException;
use App\Models\Department;
use App\Services\DepartmentsService;
use App\Services\RolesService;
use App\Services\SpecialitiesService;
use App\User;
use Illuminate\Http\Request;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class SpecialitiesController extends Controller
{
    protected $specialitiesService, $request;

    /**
     * RolesController constructor.
     * @param RolesService $rolesService
     * @param Request $request
     */
    public function __construct(SpecialitiesService $specialitiesService, Request $request)
    {
        $this->specialitiesService = $specialitiesService;
        $this->request = $request;
    }

    /**
     * 返回主视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('backend.admin.specialities.index');
    }

    /**
     * 返回添加视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAddForm()
    {
        return view('backend.admin.specialities.add');
    }

    /**
     * 执行添加操作
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function add()
    {
        return $this->specialitiesService->addSpeciality($this->request);
    }

    /**
     * 执行删除操作
     * @return string
     */
    public function delete()
    {
        return $this->specialitiesService->deleteSpeciality($this->request);
    }

    /**
     * 执行修改操作
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit()
    {
        return $this->specialitiesService->editSpeciality($this->request);
    }

    public function showEditForm()
    {
        return $this->specialitiesService->showEditPage($this->request);
    }

    public function getSpecialities()
    {
        return $this->specialitiesService->getSpecialities($this->request);
    }

}
