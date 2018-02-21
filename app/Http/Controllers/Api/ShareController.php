<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ShareController extends Controller
{
    public $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * 获取用户身份信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoles()
    {
        try
        {
            return response()->json([
                'status' => 200,
                'data' => Auth::guard('api')->user()->roles
            ]);
        }
        catch (Exception $exception)
        {
            return response()->json([
                'status' => 404,
                'message' => '未知错误']);
        }
    }

    /**
     * 获取用户信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsers()
    {
        try
        {
            $user = Auth::guard('api')->user();
            $teacher = $user->teacher;
            $speciality = $teacher->speciality;
            $department = $speciality->department;
            $info =[
                'spe_id'=>$speciality->id,
                'speciality'=>[
                    'id'=>$speciality->id,
                    'name'=>$speciality->spe_name,
                    'desc'=>$speciality->desc,
                    'dep_id' => $speciality->depar_id,
                    'department' => [
                        'id' => $department->id,
                        'name' => $department->depar_name,
                        'desc' =>$department->desc
                    ]
                ]
            ];
            $data = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'info' => $info
            ];
            $re = [
                'status' => 200,
                'data' => $data
            ];
            return response()->json($re);
        }
        catch (Exception $exception)
        {
            return response()->json([
                'status' => 404,
                'message' => '产生异常']);
        }
    }

    /**
     * 用户信息修改
     * @return \Illuminate\Http\JsonResponse
     */
    public function patchUsers()
    {
        try
        {
            $this->validate($this->request,[
                'id'=>'required|integer',
                'name' => 'string',
                'headshot' => 'string'
            ]);
            $user = User::query()->find($this->request->get('id'));
            if (!empty($user))
            {
                $user->name = $this->request->get('name');
                $user->headshot = $this->request->get('headshot');
                $user->save();
                return response()->json([
                    'status' => 200,
                ]);
            }
            else
            {
                return response()->json([
                    'status' => 404,
                    'message' => '找不到该用户']);
            }
        }
        catch (Exception $exception)
        {
            return response()->json([
                'status' => 404,
                'message' => '数据不规范或系统异常']);
        }
    }

}
