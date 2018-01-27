<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 18-1-27
 * Time: 下午6:09
 */

namespace app\Presenters;


use App\Models\Setting;

class SettingsPresenter
{
    protected $setting;
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }
    public function all()
    {
        $settings = $this->setting->all();
        $data = null;
        foreach ($settings as $setting)
        {
            $data .= '<tr>'
                .'<td>'.$setting->key.'</td>'
                .'<td>'.$setting->value.'</td>'
                .'<td>
                    <button type="button" class="btn btn-danger" onclick="deleteSetting('.$setting->id.')">删除</button>
                    <a href="'.route('show.edit.setting.form')
                .'?id='.$setting->id.'"><button type="button" class="btn btn-warning"">修改</button></a>
                  </td>'
                .'</tr>';
        }
        return $data;
    }
}