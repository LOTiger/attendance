<?php

namespace App\Http\Controllers\Backend;

use App\Services\StudentsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentsController extends Controller
{
    protected $request, $studentsService;
    public function __construct(Request $request, StudentsService $studentsService)
    {
        $this->studentsService = $studentsService;
        $this->request = $request;
    }

    public function index()
    {
        return view('backend.admin.students.index');
    }

    public function showAddForm()
    {
        return view('backend.admin.students.add');
    }

    public function add()
    {
        return $this->studentsService->add($this->request);
    }

    public function importStudents()
    {
        return $this->studentsService->import($this->request);
    }

    public function export()
    {
        return response()->download(storage_path('demo').'/students.xlsx');
    }

    
}
