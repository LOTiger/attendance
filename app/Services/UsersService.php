<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-14
 * Time: 上午11:45
 */

namespace App\Services;


use App\Exceptions\IllegaInputException;
use App\Models\Classes;
use App\Models\Counselor;
use App\Models\Department;
use App\Models\Speciality;
use App\Models\Student;
use App\Models\Teacher;
use App\User;
use Bican\Roles\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class UsersService extends Service
{

    public function add(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|string|max:255',
            'account' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'roles' => 'required'
        ]);
        $user = $this->create($request->all());
        $this->checkExit($request,'roles')? $user->attachRolesArray($request->get('roles')):null;
        $this->roleRelation($request->get('roles'),$user->id);
        return redirect('backend/users')->with('tips',['icon' => 6,'msg' => '添加成功']);
    }

    /**
     * 删除用户
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $this->validate($request,['id'=>'required']);
        $this->checkCan('delete.user');
        $this->checkNum($request->get('id'),true,new IllegaInputException());

        $user = User::query()->find($request->get('id'));

        $user->detachAllRoles();

        $user->detachAllPermissions();

        $user->delete();

        return response()->json(['state' => 1]);
    }

    /**
     * 返回修改视图
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bindUserForm(Request $request)
    {
        $this->validate($request,['id'=>'required']);
        $this->checkNum($request->get('id'),true,new IllegaInputException());
        $id = $request->get('id');
        return view('backend.admin.users.edit',compact('id'));
    }

    /**
     * 修改用户
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'roles' => 'required'
        ]);
        $this->checkCan('edit.user');
        $this->checkNum($request->get('id'),true,new IllegaInputException());

        return $this->doEditAction($request);
    }

    /**
     * 修改用户操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function doEditAction(Request $request)
    {
        $user = $this->getUser($request->get('id'));
        $user->detachAllRoles();
        $this->checkExit($request,'roles')? $user->attachRolesArray($request->get('roles')):null;
        return redirect('backend/users')->with('tips',['icon' => 6,'msg' => '修改成功']);

    }

    protected function create($data)
    {
        return User::query()->create([
            'name' => $data['name'],
            'account' => $data['account'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function roleRelation(Array $roles,$user)
    {
        if (!empty($roles))
        {
            foreach ($roles as $role)
            {
                $r = Role::query()->find($role);
                switch ($r->slug)
                {
                    case 'teacher':
                        Teacher::query()->create([
                            'user_id' => $user,
                            'spe_id' => Speciality::query()->first()->id
                        ]);
                        break;
                    case 'student':
                        Student::query()->create([
                            'user_id' => $user,
                            'class_id' => Classes::query()->first()->id
                        ]);
                        break;
                    case 'counselor':
                        Counselor::query()->create([
                            'user_id' => $user,
                            'depar_id' => Department::query()->first()->id
                        ]);
                }
            }
        }
    }




}