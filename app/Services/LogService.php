<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-11-26
 * Time: 下午4:03
 */

namespace App\Services;


use App\User;
use Bican\Roles\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Rap2hpoutre\LaravelLogViewer\LaravelLogViewer;

class LogService
{
    protected $LogViewer;


    public function _construct()
    {
        $this->LogViewer = LaravelLogViewer::all();
    }

    public function getAllLog()
    {
        $logs = LaravelLogViewer::all();
        $files = LaravelLogViewer::getFiles(true);
        $current_file = LaravelLogViewer::getFileName();
        return (object)[
            'logs' => $logs,
            'current_file' => $current_file
        ];
    }

    public function checkAction(Request $request)
    {
        if ($request->input('l'))
        {
            LaravelLogViewer::setFile(base64_decode($request->input('l')));
        }
        if ($request->input('dl'))
        {

            return $this->download(LaravelLogViewer::pathToLogFile(base64_decode($request->input('dl'))));
        }
        elseif ($request->has('del'))
        {
            $user = User::find(Auth::id());
            if ($user->can('delete.log')) {
                app('files')->delete(LaravelLogViewer::pathToLogFile(base64_decode($request->input('del'))));
                Log::warning("使用者id:".Auth::id().",删除了日志:".base64_decode($request->input('del')));
                return $this->redirect($request->url());
            }
            else
            {

            }

        }
        elseif ($request->has('delall'))
        {
            foreach(LaravelLogViewer::getFiles(true) as $file)
            {
                app('files')->delete(LaravelLogViewer::pathToLogFile($file));
            }
            return $this->redirect($request->url());
        }
    }

    private function redirect($to)
    {
        if (function_exists('redirect'))
        {
            return redirect($to);
        }

        return app('redirect')->to($to);
    }

    private function download($data)
    {

        if (function_exists('response'))
        {
            return response()->download($data);
        }
        // For laravel 4.2
        return app('\Illuminate\Support\Facades\Response')->download($data);
    }


}