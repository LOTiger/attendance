<?php

namespace App\Http\Controllers\Backend;

use App\Services\DashboardService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    protected $request,$service;

    public function __construct(Request $request, DashboardService $service)
    {
        $this->service = $service;
        $this->service->request = $request;
    }
    public function index()
    {
        return view('backend.admin.dashboard.index');
    }

    public function getChartData()
    {
        return $this->service->getChartData();
    }

    public function dataReader()
    {
        return $this->service->dataReader();
    }

    public function export()
    {
        return $this->service->export();
    }

}
