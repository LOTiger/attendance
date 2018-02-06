<?php

namespace App\Http\Controllers\Backend;

use App\Services\CounselorsService;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CounselorsController extends Controller
{
    protected $request, $counselorsService;

    public function __construct(Request $request, CounselorsService $service)
    {
        $this->request = $request;
        $this->counselorsService = $service;
    }

    public function index()
    {
        return $this->counselorsService->index($this->request);
    }

    public function showEditForm()
    {
        return $this->counselorsService->showEditForm($this->request);
    }

    public function showUpadateForm()
    {
        return $this->counselorsService->showUpadateForm($this->request);
    }

    public function showAddForm()
    {
        return $this->counselorsService->showAddForm($this->request);
    }

    public function addCounselor()
    {
        return $this->counselorsService->addCounselor($this->request);
    }

    public function editCounselor()
    {
        return $this->counselorsService->editCounselor($this->request);
    }

    public function deleteCounselor()
    {
        return $this->counselorsService->deleteCounselor($this->request);
    }

    public function showClasses()
    {
        return $this->counselorsService->showClasses($this->request);
    }

    public function showaddClasses()
    {
        return $this->counselorsService->showaddClasses($this->request);
    }

    public function counseloraddclass()
    {
        return $this->counselorsService->counseloraddclass($this->request);
    }

    public function getclassinfo()
    {
        return $this->counselorsService->getclassinfo($this->request);
    }

    public function showcounselorclass()
    {
        return $this->counselorsService->showcounselorclass($this->request);
    }

    public function editcounselorclass()
    {
        return $this->counselorsService->editcounselorclass($this->request);
    }
}
