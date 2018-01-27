<?php

namespace App\Http\Controllers\Backend;

use App\Services\SettingsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    protected $service;
    public function __construct(SettingsService $service, Request $request)
    {
        $this->service = $service;
        $this->service->request = $request;
    }
    
    public function index()
    {
        return view('backend.admin.settings.index');
    }

    public function add()
    {
        return $this->service->add();
    }

    public function delete()
    {
        return $this->service->delete();
    }

    public function editForm()
    {
        return $this->service->editForm();
    }

    public function edit()
    {
        return $this->service->edit();
    }

}
