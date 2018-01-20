<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-13
 * Time: 下午3:26
 */

namespace App\Http\Controllers\Backend;


use App\Services\UsersService;
use Illuminate\Http\Request;

class UsersController
{
    protected $request, $UsersService;
    public function __construct(Request $request, UsersService $service)
    {
        $this->request = $request;
        $this->UsersService = $service;
    }

    public function index()
    {
        return view('backend.admin.users.index');
    }

    public function delete()
    {
        return $this->UsersService->delete($this->request);
    }

    public function showBindRoleForm()
    {
        return $this->UsersService->bindUserForm($this->request);
    }

    public function edit()
    {
        return $this->UsersService->edit($this->request);
    }

    public function showAddForm()
    {
        return view('backend.admin.users.add');
    }

    public function add()
    {
        return $this->UsersService->add($this->request);
    }

}