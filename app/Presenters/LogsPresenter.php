<?php

namespace App\Presenters;
use App\Services\LogService;
use Rap2hpoutre\LaravelLogViewer\LaravelLogViewer;


/**
 * Class LogsPresenter
 *
 * @package App\Presenters
 */
class LogsPresenter
{
    protected $LogViewer;
    /**
     * @param string $gender
     * @param string $name
     *
     * @return string
     */
    protected $logService;

    public function _construct()
    {
        $this->LogViewer = LaravelLogViewer::all();
    }

    /**
     * 获取所有日志名字
     * @return object
     */
    public function getFiles()
    {
        $files = LaravelLogViewer::getFiles(true);
        return (object)['files' => $files];
    }

    /**
     * 获取日志级别为info的条数
     * @return mixed
     */
    public function getInfoNum()
    {
        return $this->getLogLevelNum()->info;
    }

    /**
     * 获取日志级别为警告的条数
     * @return mixed
     */
    public function getWarningNum()
    {
        return $this->getLogLevelNum()->warning;
    }

    /**
     * 获取错误日志条数
     * @return object
     */
    public function getLogLevelNum()
    {
        $logs = LaravelLogViewer::all();
        $numOfInfo = 0;
        $numOfWarning = 0;
        foreach ($logs as $log)
        {
            if ($log['level_img'] == 'info')
            {
                $numOfInfo +=1;
            }
            elseif ($log['level_img'] == 'warning')
            {
                $numOfWarning +=1;
            }
        }

        return (object)[
            'info' => $numOfInfo,
            'warning' => $numOfWarning
        ];

    }

}