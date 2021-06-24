<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminBuildingDetail extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminBuildingDetail Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'parameter' => [
                'name'        => 'AdminBuildingDetail Component',
                'description' => 'No description provided yet...'
            ]
        ];
    }

    public function onRun()
    {
        $building = $this->getCurrent();
        if(!$building) {

            return;
        }

        $this->page['building'] = $building;
    }

    public function getCurrent()
    {
        return \Ams\Location\Models\Building::whereParameter($this->property('parameter'))->first();
    }

    public function onSave()
    {
        $building            = $this->getCurrent();
        $building->office_id = post('office_id');
        $building->name      = post('name');
        $building->save();

        \Flash::success('Gedung berhasil disimpan');
        return \Redirect::to('building');
    }
}
