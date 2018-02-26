<?php

namespace App\Http\Controllers\Backend;

use App\Services\StudentsService;
use App\Services\TeachersService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeachersController extends Controller
{
    protected $request, $teacherService;
    public function __construct(Request $request, TeachersService $service)
    {
        $this->teacherService = $service;
        $this->request = $request;
    }

    public function index()
    {
        return view('backend.admin.teachers.index');
    }

    public function showAddForm()
    {
        return view('backend.admin.teachers.add');
    }

    public function add()
    {
        return $this->teacherService->add($this->request);
    }

    public function importTeachers()
    {
        return $this->teacherService->import($this->request);
    }

    public function export()
    {
        return response()->download(storage_path('demo').'/teachers.xlsx');
    }
    
}
