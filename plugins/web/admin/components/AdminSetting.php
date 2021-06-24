<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminSetting extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminSetting Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $this->page['settings'] = new \Ams\Setting\Models\Setting;
    }

    public function onGenerate()
    {
        $generator = new \Ams\Core\Classes\Generator;
        $settings  = \Ams\Setting\Models\Setting::whereName('lable_type')->first()->value;
        $assets    = \Ams\Asset\Models\AssetItem::whereDoesntHave('lable')->take(50)->get();
        foreach ($assets as $asset) {
            $generator->makeBarcode($asset);

            if($settings == 'simple') {
                $generator->makeLableSimple($asset);
            }
            else {
                $generator->makeLableQr($asset);
            }
        }

        \Flash::success('Label berhasil dibuat ulang');
        return;
    }

    public function onSave()
    {
        $configKey   = array_keys(post('config')['name']);
        $configValue = array_values(post('config')['name']);
        foreach ($configKey as $key => $c) {
            $setting = \Ams\Setting\Models\Setting::firstOrCreate([
                'name'  => $configKey[$key],
            ]);
            $setting->value = $configValue[$key];
            $setting->save();
        }

        \Flash::success('Pengaturan berhasil disimpan');
        return \Redirect::refresh();
    }
}
