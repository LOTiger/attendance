<?php

namespace App\Http\Controllers\Backend;

use App\Services\LessonsService;
use App\Services\StudentsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LessonsController extends Controller
{
    protected $request, $lessonsService;
    public function __construct(Request $request, LessonsService $service)
    {
        $this->lessonsService = $service;
        $this->request = $request;
    }



    public function showAddForm()
    {
        return view('backend.admin.lessons.add');
    }

    public function add()
    {
        return $this->lessonsService->add($this->request);
    }

    public function importStudents()
    {
        return $this->lessonsService->import($this->request);
    }
    
}
