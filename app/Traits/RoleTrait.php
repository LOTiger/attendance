<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-13
 * Time: 下午3:06
 */

namespace App\Traits;


trait RoleTrait
{
    public function detachAllPermission()
    {
        return $this->permissions()->detach();
    }

    public function detachAllUser()
    {
        return $this->users()->detach();
    }
}