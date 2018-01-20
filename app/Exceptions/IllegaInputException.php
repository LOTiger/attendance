<?php

namespace App\Exceptions;
use Exception;


class IllegaInputException extends Exception
{
    /**
     * Create a new permission denied exception instance.
     *
     * @param string $permission
     */
    public function __construct($mes = "非法输入")
    {
        $this->message = sprintf($mes);
    }
}
