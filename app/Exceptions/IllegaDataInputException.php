<?php

namespace App\Exceptions;
use Exception;


class IllegaDataInputException extends Exception
{
    /**
     * Create a new permission denied exception instance.
     *
     * @param string $permission
     */
    public function __construct($mes = "录入数据异常")
    {
        $this->message = sprintf($mes);
    }
}
