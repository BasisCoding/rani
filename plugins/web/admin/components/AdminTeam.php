<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminTeam extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminTeam Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function getAll()
    {
        return \Ams\Employee\Models\Team::orderBy('name', 'asc')->get();
    }

    public function getDepartment()
    {
        $department = new \Ams\Core\Classes\EmployeeHelpers;
        return $department->getDepartment();
    }

    public function onSave()
    {
        $team                = new \Ams\Employee\Models\Team;
        $team->department_id = post('department_id');
        $team->name          = post('name');
        $team->save();

        \Flash::success('Team berhasil disimpan');
        return \Redirect::to('team');
    }
}
