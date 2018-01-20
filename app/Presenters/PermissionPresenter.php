<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-4
 * Time: 下午10:32
 */

namespace App\Presenters;


use App\Exceptions\PermissionDeniedException;
use Bican\Roles\Models\Permission;
use Bican\Roles\Models\Role;

class PermissionPresenter extends Presenter
{

    public function __construct()
    {

    }

    public function getPermissionsFromRoleForAdd($role_id = null)
    {
        $data = '';
        if ($role_id)
        {
            $role = Role::query()->find($role_id);
            foreach (Permission::all() as $permission)
            {
                $data .= '<label>'
                    .'<input type="checkbox" name="permissions[]" class="minimal" value="'
                    .$permission->id.'"';
                if ($this->theRoleHasOne($permission->id, $role))
                {
                    $data .= 'checked="checked"';
                }
                $data .=' >'
                    .$permission->name
                    .'</label>';
            }
        }
        else
        {
            foreach (Permission::all() as $permission)
            {
                $data .= '<label>'
                    .'<input type="checkbox" name="permissions[]" class="minimal" value="'
                    .$permission->id.'"'
                    .' >'
                    .$permission->name
                    .'</label>';
            }
        }
        return $data;
    }

    protected function theRoleHasOne($permission_id, Role $role)
    {
        foreach ($role->permissions as $permission)
        {
            if ($permission->id == $permission_id)
                return true;
        }
        return false;
    }

    public function getAllPermissions()
    {
        $data = '';
        foreach (Permission::all() as $permission)
        {
            $data .= '<tr>'
                .'<td>'.$permission->name.'</td>'
                .'<td>'.$permission->description.'</td>'
                .'<td>'.$permission->created_at.'</td>'
                .'<td>'.$permission->updated_at.'</td>'
                .'<td>
                    <button type="button" class="btn btn-danger" onclick="deletePermission('.$permission->id.')">删除</button>
                    <a href="'.route('show.edit.permission.form')
                .'?id='.$permission->id.'"><button type="button" class="btn btn-warning"">修改</button></a>
                  </td>'
                .'</tr>';
        }
        return $data;
    }



}