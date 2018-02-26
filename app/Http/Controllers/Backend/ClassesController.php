<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-18
 * Time: 下午9:46
 */

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Services\ClassesService;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    protected $request,$classesService;
    public function __construct(Request $request,ClassesService $classesService)
    {
        $this->request = $request;
        $this->classesService = $classesService;
    }

    public function index()
    {
        return view('backend.admin.classes.index');
    }

    public function showAddForm()
    {
        return view('backend.admin.classes.add');
    }

    public function add()
    {
        return $this->classesService->add($this->request);
    }

    public function importClasses()
    {
        return $this->classesService->import($this->request);
    }

    public function delete()
    {
        return $this->classesService->delete($this->request);
    }

    public function export()
    {
        return response()->download(storage_path('demo').'/classes.xlsx');
    }


}