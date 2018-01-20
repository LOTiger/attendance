<?php

namespace App\Http\Controllers\Backend;

use App\Services\BuildsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuildsController extends Controller
{
    protected $request, $buildsService;

    public function __construct(Request $request, BuildsService $service)
    {
        $this->request = $request;
        $this->buildsService = $service;
    }

    public function index()
    {
        return $this->buildsService->index($this->request);
    }

    public function showAddForm()
    {
        return view('backend.admin.builds.add');
    }

    public function add()
    {
        return $this->buildsService->add($this->request);
    }

    public function addRoom()
    {
        return $this->buildsService->addRoom($this->request);
    }

    public function delete()
    {
        return $this->buildsService->delete($this->request);
    }

    public function deleteRoom()
    {
        return $this->buildsService->deleteRoom($this->request);
    }

    public function showEditForm()
    {
        return $this->buildsService->showEditForm($this->request);
    }

}
