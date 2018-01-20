<?php

namespace App\Http\Controllers\Backend;

use App\Services\PermissionsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionsController extends Controller
{
    protected $request, $permissionsService;
    public function __construct(Request $request, PermissionsService $permissionsService)
    {
        $this->request = $request;
        $this->permissionsService = $permissionsService;
    }

    public function index()
    {
        return view('backend.admin.permissions.index');
    }

    public function showAddForm()
    {
        return view('backend.admin.permissions.add');
    }

    public function add()
    {
        return $this->permissionsService->add($this->request);
    }

    public function delete()
    {
        return $this->permissionsService->delete($this->request);
        //return response()->json(['state' => 1, 'id:'=>$this->request->get('id')]);
    }

    public function showBindRoleForm()
    {
        return $this->permissionsService->bindRoleForm($this->request);
    }

    public function edit()
    {
        return $this->permissionsService->edit($this->request);
    }


}
