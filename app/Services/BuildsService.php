<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-4
 * Time: 下午10:59
 */

namespace App\Services;

use App\Exceptions\IllegaInputException;
use App\Models\Build;
use App\Models\Room;
use Illuminate\Http\Request;
class BuildsService extends Service
{

    public function index(Request $request)
    {
        $id = null;
        if ($request->has('id'))
        {
            $this->checkNum($request->get('id'),true,new IllegaInputException());
            $id = $request->get('id');
        }
        return view('backend.admin.builds.index',compact('id'));
    }

    public function add(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'height' => 'required|integer',
            'room' => 'required|integer'
        ]);
        if (!Build::checkBuildExit($request->get('name')))
        {
            $build = Build::query()->create(['build_name' => $request->get('name')]);
            for ($i=1;$i<=$request->get('height');$i++ )
            {
                for ($j=1;$j<=$request->get('room');$j++)
                {
                    $roomName = (string)$i.sprintf('%02d',$j);
                    Room::query()->create(['room_name'=>$roomName,'build_id'=>$build->id]);
                }
            }
            return redirect()->route('builds')->with('tips' , ['icon'=>6,'msg'=>'教学楼添加成功']);
        }
        else
        {
            return back()->withInput()->with('tips' , ['icon'=>5,'msg'=>'该教学楼已存在']);
        }
    }

    public function delete(Request $request)
    {
        $this->checkCan('delete.build');
        $this->validate($request,[
            'id' => 'required|integer',
        ]);
        Build::query()->find($request->get('id'))->delete();
        return response()->json(['state' => 1]);
    }

    public function addRoom(Request $request)
    {
        $this->validate($request,[
            'room' => 'required|integer',
            'build_id' => 'required|integer',
        ]);
        if (!Room::checkRoom($request->get('build_id'),$request->get('room')))
        {
            Room::query()->create(['room_name'=>$request->get('room'),'build_id'=>$request->get('build_id')]);
            return redirect()->back()->with('tips' , ['icon'=>6,'msg'=>'课室添加成功']);
        }
        else
        {
            return back()->withInput()->with('tips' , ['icon'=>5,'msg'=>'该课室号已存在']);
        }
    }

    public function showEditForm(Request $request)
    {
        $this->validate($request,['id'=>'required|integer']);
        $id = $request->get('id');
        return view('backend.admin.builds.room',compact('id'));
    }

    public function deleteRoom(Request $request)
    {
        $this->checkCan('delete.room');
        $this->validate($request,[
            'id' => 'required|integer',
        ]);
        Room::query()->find($request->get('id'))->delete();
        return response()->json(['state' => 1]);
    }

}