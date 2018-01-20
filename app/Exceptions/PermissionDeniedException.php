<?php

namespace App\Exceptions;
use Exception;
use Illuminate\Support\Facades\Auth;


class PermissionDeniedException extends Exception
{
    /**
     * Create a new permission denied exception instance.
     *
     * @param string $permission
     */
    public function __construct($permission)
    {
        $this->message = sprintf("用户id['%s']:企图执行 ['%s'] 权限，可惜被禁止了.", Auth::id(),$permission);
    }
}
