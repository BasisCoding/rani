<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminUnitDetail extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminUnitDetail Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'parameter' => [
                'name'        => 'AdminUnitDetail Component',
                'description' => 'No description provided yet...'
            ]
        ];
    }

    public function onRun()
    {
        $unit = $this->getCurrent();
        if(!$unit) {

            return;
        }

        $this->page['unit'] = $unit;
    }

    public function getCurrent()
    {
        return \Ams\Employee\Models\Unit::whereParameter($this->property('parameter'))->first();
    }

    public function onSave()
    {
        $unit          = $this->getCurrent();
        $unit->team_id = post('team_id');
        $unit->name    = post('name');
        $unit->save();

        \Flash::success('Unit berhasil disimpan');
        return \Redirect::to('unit');
    }
}
