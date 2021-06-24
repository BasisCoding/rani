<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminUnit extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminUnit Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function getAll()
    {
        return \Ams\Employee\Models\Unit::orderBy('name')->get();
    }

    public function getTeam()
    {
        return \Ams\Employee\Models\Team::orderBy('name')->get();
    }

    public function onSave()
    {
        $unit          = new \Ams\Employee\Models\Unit;
        $unit->team_id = post('team_id');
        $unit->name    = post('name');
        $unit->save();

        \Flash::success('Unit berhasil disimpan');
        return \Redirect::to('unit');
    }
}
