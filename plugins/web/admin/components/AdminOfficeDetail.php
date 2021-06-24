<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminOfficeDetail extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminOfficeDetail Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'parameter' => [
                'name'        => 'AdminOfficeDetail Component',
                'description' => 'No description provided yet...'
            ]
        ];
    }

    public function onRun()
    {
        $office = $this->getCurrent();
        if(!$office) {

            return;
        }

        $this->page['office'] = $office;
    }

    public function getCurrent()
    {
        return \Ams\Location\Models\Office::whereParameter($this->property('parameter'))->first();
    }

    public function onSave()
    {
        $office              = $this->getCurrent();
        $office->name        = post('name');
        $office->code        = post('code');
        $office->province_id = post('province_id');
        $office->regency_id  = post('regency_id');
        $office->district_id = post('district_id');
        $office->village_id  = post('village_id');
        $office->address     = post('address');
        $office->save();

        \Flash::success('Kantor berhasil disimpan');
        return \Redirect::to('office');
    }
}
