<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-12
 * Time: 下午11:25
 */

namespace App\Traits;


trait PermissionTrait
{
    public function detachAllRole()
    {
        return $this->roles()->detach();
    }

    public function detachAllUser()
    {
        return $this->users()->detach();
    }

}