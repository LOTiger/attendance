<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 18-1-27
 * Time: 下午2:49
 */

namespace App\Services;

use App\Models\Setting;
use Exception;
use Illuminate\Support\Facades\Storage;

class SettingsService extends Service
{
    public $request;
    protected $setting;

    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    /**
     * 新增配置项
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add()
    {
        if (empty($this->request->all()))
            return view('backend.admin.settings.add');
        $this->validate($this->request,[
            'key'=>'required',
            'value' =>'required',
            'name' =>'required'
        ]);
        if ($this->set($this->request->get('key'),$this->request->get('value'),$this->request->get('name')))
            return redirect()->route('settings')->with('tips' , ['icon'=>6,'msg'=>'新增成功']);
        else
            return redirect()->back()->with('tips' , ['icon'=>5,'msg'=>'新增失败,未知错误']);
    }

    /**
     * 删除配置项
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete()
    {
        $this->validate($this->request,[
            'id'=>'required|integer'
        ]);
        try
        {
            $this->setting->where('id',$this->request->get('id'))->delete();
            return response()->json(['state' => 1]);
        }
        catch (Exception $exception)
        {
            return response()->json(['state' => 0]);
        }
    }

    /**
     * 修改配置项
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit()
    {
        $this->validate($this->request,[
            'key'=>'required',
            'value' =>'required',
            'name' =>'required'
        ]);
        return $this->set($this->request->get('key'),$this->request->get('value'),$this->request->get('name'))
            ?redirect()->route('settings')->with('tips' , ['icon'=>6,'msg'=>'修改成功']):
            redirect()->back()->with('tips' , ['icon'=>5,'msg'=>'修改失败,未知错误']);
    }


    /**
     * 返回修改视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editForm()
    {
        $this->validate($this->request,[
            'id'=>'required|integer'
        ]);
        $setting = $this->setting->find($this->request->get('id'));
        return view('backend.admin.settings.edit',compact('setting'));
    }

    /**
     * 对配置项的增删改
     * @param $key
     * @param $value
     * @return bool
     */
    protected function set($key,$value,$name)
    {
        try
        {
            if ($value === null)
            {
                $this->setting->where('key', $key)->delete();
            }
            else
            {
                $this->setting->updateOrCreate(compact('key'), compact('value','name'));
            }
            return true&&$this->exportToConfigFile();
        }
        catch (Exception $exception)
        {
            return false;
        }
    }

    public function exportToConfigFile()
    {
        try
        {
            $settings = [];
            $this->getSettings()->map(function ($setting) use (&$settings) {
                $settings[$setting->key] = $setting->value;
            });
            $cache_content = '<?php'. PHP_EOL
                .'return ' . var_export($settings, true) . ';';
            Storage::disk('local')->put('settings.php', $cache_content);
            return true;
        }
        catch (Exception $exception)
        {
            return false;
        }

    }

    protected function getSettings()
    {
        return Setting::all();
    }

}