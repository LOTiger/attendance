<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-13
 * Time: 下午3:37
 */

namespace App\Presenters;


use App\User;
use Bican\Roles\Models\Role;
use Illuminate\Support\Facades\Auth;

class UsersPresenter extends Presenter
{
    public function getAllUsers()
    {
        $data = '';
        foreach (Auth::user()->getLowLevelUsers() as $user)
        {
            $data .= '<tr>'
                .'<td>'.$user->name.'</td>'
                .'<td>'.$user->email.'</td>'
                .'<td>'.$this->getRoleOfUser($user->id).'</td>'
                .'<td>'.$user->created_at.'</td>'
                .'<td>'.$user->updated_at.'</td>'
                .'<td>
                    <button type="button" class="btn btn-danger" onclick="deleteUser('.$user->id.')">删除</button>
                    <a href="'.route('show.edit.user.form')
                .'?id='.$user->id.'"><button type="button" class="btn btn-warning"">修改</button></a>
                  </td>'
                .'</tr>';
        }
        return $data;
    }



    protected function getRoleOfUser($id, $toString = true)
    {
        $user = User::query()->find($id);
        $roles = $user->roles;
        $data = '';
        if ($toString)
        {
            foreach ($roles as $role)
            {
                $data .=$role->name."\t";
            }
        }
        else
            $data = $roles;
        return $data;
    }

    public function getRoleLabel($id=null)
    {
        $data = null;
        if ($id)
        {
            foreach ($this->getAllRoles() as $role)
            {
                $data .= '<label>'
                    .'<input type="checkbox" name="roles[]" class="minimal" value="'
                    .$role->id.'"';
                if ($this->theUserHasRole($id, $role))
                {
                    $data .= 'checked="checked"';
                }
                $data .=' >'
                    .$role->name
                    .'</label>';
            }
        }
        else
        {
            foreach ($this->getAllRoles() as $role)
            {
                $data .= '<label>'
                    .'<input type="checkbox" name="roles[]" class="minimal" value="'
                    .$role->id.'"';
                $data .=' >'
                    .$role->name
                    .'</label>';
            }
        }

        return $data;
    }

    protected function theUserHasRole($user_id,$role)
    {
        foreach ($role->users as $user)
        {
            if ($user->id == $user_id)
                return true;
        }
        return false;
    }

}