<?php

namespace App\Http\Controllers\Backend;

use App\Services\LogService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class LogController extends Controller
{
    protected $request, $logService;

    public function __construct (Request $request, LogService $logService)
    {
        $this->request = $request;
        $this->logService = $logService;
    }

    /**
     * 检查日志操作，返回日志视图
     * @return $this
     */
    public function index()
    {
        return $this->logService->checkAction($this->request)?:
            view('backend.admin.log')
                ->with([
                    'logs' => $this->logService->getAllLog()->logs,
                    'current_file' => $this->logService->getAllLog()->current_file
                ]);
    }

}
